/*
** One-time sync: upload categories from storage.fondex.uz backend to Firestore.
** Existing Firestore docs are NOT touched — only missing categories are created.
**
** Usage:
**   node syncCategoriesToFirestore.js --dry-run   (show what would be created)
**   node syncCategoriesToFirestore.js             (actually create missing docs)
*/
const admin = require("firebase-admin");
const serviceAccount = require('./credentials.json');

admin.initializeApp({
    credential: admin.credential.cert(serviceAccount)
});

const firestore = admin.firestore();
const API_URL = 'https://storage.fondex.uz/api/categories/';
const DRY_RUN = process.argv.includes('--dry-run');

// PHP uniqid() style id generator (13 hex chars based on time + entropy)
function uniqid() {
    var ts = Math.floor(Date.now() / 1000).toString(16);
    var rand = Math.floor(Math.random() * 0xfffff).toString(16).padStart(5, '0');
    return ts + rand;
}

async function fetchAllBackendCategories() {
    var results = [];
    var page = 1;
    while (true) {
        var res = await fetch(API_URL + '?page=' + page + '&page_size=100');
        var json = await res.json();
        if (!json.status || !json.data || !json.data.results) {
            throw new Error('Unexpected API response on page ' + page + ': ' + JSON.stringify(json).slice(0, 300));
        }
        results = results.concat(json.data.results);
        if (!json.data.links || !json.data.links.next) break;
        page++;
    }
    return results;
}

async function main() {
    console.log('Mode:', DRY_RUN ? 'DRY RUN (nothing will be written)' : 'LIVE');

    var backendCats = await fetchAllBackendCategories();
    console.log('Backend categories:', backendCats.length);

    var snapshot = await firestore.collection('vendor_categories').get();
    console.log('Existing Firestore categories:', snapshot.size);

    var existingIds = new Set();
    var existingTitleSection = new Set();
    snapshot.docs.forEach(function (doc) {
        existingIds.add(doc.id);
        var data = doc.data();
        if (data.id) existingIds.add(String(data.id));
        var key = String(data.title || '').trim().toLowerCase() + '|' + String(data.section_id || '');
        existingTitleSection.add(key);
    });

    var created = 0, skippedById = 0, skippedByTitle = 0, errors = 0;

    for (var i = 0; i < backendCats.length; i++) {
        var cat = backendCats[i];
        var title = String(cat.title || '').trim();
        var fid = cat.firestore_id ? String(cat.firestore_id) : '';
        var titleKey = title.toLowerCase() + '|' + String(cat.section || '');

        if (fid && existingIds.has(fid)) {
            skippedById++;
            continue; // already in Firebase — do not touch
        }
        if (existingTitleSection.has(titleKey)) {
            skippedByTitle++;
            console.log('SKIP (same title+section already in Firebase):', title, '| backend pk:', cat.id);
            continue;
        }

        var docId = fid || uniqid();
        var payload = {
            'id': docId,
            'title': title,
            'description': cat.description || '',
            'photo': cat.photo || cat.photo_url || '',
            'order': parseInt(cat.order) || 0,
            'section_id': cat.section || '',
            'review_attributes': [],
            'publish': !!cat.is_publish,
            'show_in_homepage': false
        };

        if (DRY_RUN) {
            console.log('WOULD CREATE:', docId, '|', title, '| section:', payload.section_id, '| publish:', payload.publish, '| backend pk:', cat.id, fid ? '' : '(no firestore_id in backend)');
            created++;
        } else {
            try {
                await firestore.collection('vendor_categories').doc(docId).set(payload);
                existingIds.add(docId);
                existingTitleSection.add(titleKey);
                console.log('CREATED:', docId, '|', title, '| backend pk:', cat.id);
                created++;
            } catch (e) {
                errors++;
                console.error('ERROR creating', title, '| backend pk:', cat.id, '->', e.message);
            }
        }
    }

    console.log('---');
    console.log((DRY_RUN ? 'Would create: ' : 'Created: ') + created);
    console.log('Skipped (already in Firebase by id): ' + skippedById);
    console.log('Skipped (same title+section in Firebase): ' + skippedByTitle);
    if (errors) console.log('Errors: ' + errors);
    process.exit(errors ? 1 : 0);
}

main().catch(function (e) {
    console.error('FATAL:', e);
    process.exit(1);
});
