**Diagram Alur — Super Admin & Admin**

- File diagram: docs/flows/superadmin-admin-flow.mmd (Mermaid)

Cara render/lihat:

1) VS Code: install extension "Markdown Preview Mermaid Support" atau "Mermaid Markdown Preview" lalu buka file `.mmd` atau paste ke file `.md`.

2) Menggunakan mermaid-cli (node):

```bash
npm install -g @mermaid-js/mermaid-cli
mmdc -i docs/flows/superadmin-admin-flow.mmd -o docs/flows/superadmin-admin-flow.png
```

3) Alternatif online: paste isi file ke https://mermaid.live/ untuk preview dan export PNG/SVG.

Catatan:
- Diagram menampilkan alur utama: login -> dashboard -> fitur-fitur per peran.
- Jika Anda ingin diagram lebih rinci (mis. proses pembuatan invoice langkah-demi-langkah), beri tahu bagian mana yang mau diperluas.
