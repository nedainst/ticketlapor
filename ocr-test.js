const text = `PROVINSI KALIMANTAN TIMUR
KOTA BONTANG
N IK : 6474031908080001
Nama  MUHAMMAD MUFTHI MUBAROK ag
Tempat/Tgl Lahir : BONTANG, 19-08-2008
Jenis kelamin : LAKI-LAKI Gol. Darah : O
Alamat JL GN. BATOK NO 15BSDPKT en.
RT/RW : 038/000
Kel/Desa : GUNUNG ELAI
Kecamatan : BONTANG UTARA
Agama : ISLAM
Status Perkawinan: BELUM KAWIN
Pekerjaan : PELAJAR/MAHASISWA
Kewarganegaraan: WNI
Berlaku Hingga : SEUMUR HIDUP`;

let extractedNik = '';
let extractedNama = '';
let extractedAlamat = '';

// 1. Ekstrak NIK (Paling gampang karena 16 digit angka)
let rawTextForNik = text.replace(/\s+/g, '').replace(/[oO]/g, '0').replace(/[lI\|]/g, '1').replace(/[bB]/g, '8').replace(/[sS]/g, '5');
const nikMatch = rawTextForNik.match(/\d{16}/);
if (nikMatch) {
    extractedNik = nikMatch[0];
}

// 2. Ekstrak Nama & Alamat line by line
const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);

for (let i = 0; i < lines.length; i++) {
    const line = lines[i];
    const lower = line.toLowerCase();
    
    if (/(provinsi|kota|kabupaten|nik)/i.test(lower)) continue;

    if (/(nama|nama\s*:)/i.test(lower) && !extractedNama) {
        let nameStr = line.replace(/^(.*?nama\s*[:;=]?\s*)/i, '').trim();
        if (nameStr.length < 3 && i + 1 < lines.length) {
            nameStr = lines[i + 1].trim();
        }
        extractedNama = nameStr.replace(/\b[a-z]{1,3}\b\.?$/g, '').replace(/[^a-zA-Z\s.,\'-]/g, '').replace(/\s+/g, ' ').trim();
    }
    
    if (/(alamat|alamat\s*:)/i.test(lower) && !extractedAlamat) {
        let alamatStr = line.replace(/^(.*?alamat\s*[:;=]?\s*)/i, '').trim();
        
        for (let j = 1; j <= 4; j++) {
            if (i + j < lines.length) {
                const nextLine = lines[i + j];
                const nextLower = nextLine.toLowerCase();
                
                if (/(agama|status|tempat|pekerjaan)/i.test(nextLower)) break;
                
                if (/(rt\/?rw)/i.test(nextLower)) {
                    alamatStr += ', ' + nextLine.replace(/^(.*?rt\/?rw\s*[:;=]?\s*)/i, 'RT/RW ');
                } else if (/(kel\/?desa)/i.test(nextLower)) {
                    alamatStr += ', ' + nextLine.replace(/^(.*?kel\/?desa\s*[:;=]?\s*)/i, 'Kel. ');
                } else if (/(kecamatan)/i.test(nextLower)) {
                    alamatStr += ', ' + nextLine.replace(/^(.*?kecamatan\s*[:;=]?\s*)/i, 'Kec. ');
                } else if (!/:/.test(nextLine)) {
                    alamatStr += ' ' + nextLine;
                }
            }
        }
        extractedAlamat = alamatStr.replace(/[^a-zA-Z0-9\s.,\/-]/g, '').replace(/\s+/g, ' ').trim();
    }
}

console.log('Result NIK:', extractedNik);
console.log('Result Nama:', extractedNama);
console.log('Result Alamat:', extractedAlamat);
