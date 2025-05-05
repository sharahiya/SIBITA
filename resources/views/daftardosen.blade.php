@extends('layouts.layoutmhs')
@section('content')
<div class="container mx-auto max-w-5xl">
<h1 class="text-center text-2xl font-bold mb-6">Daftar Dosen</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="text-center mb-4">
            <button class="tab-button px-4 py-2 mx-2 bg-blue-500 text-white rounded-lg" onclick="showCategory('rpl')">RPL</button>
            <button class="tab-button px-4 py-2 mx-2 bg-blue-500 text-white rounded-lg" onclick="showCategory('dm')">DM</button>
            <button class="tab-button px-4 py-2 mx-2 bg-blue-500 text-white rounded-lg" onclick="showCategory('jaringan')">Jaringan</button>
            <button class="tab-button px-4 py-2 mx-2 bg-blue-500 text-white rounded-lg" onclick="showCategory('gis')">GIS</button>
        </div>

        <div id="dosen-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Card dosen akan muncul di sini -->
        </div>
    </div>
</div>

<script>
    const dosenData = {
        rpl: [
            { name: "Nazaruddin Abdullah, S.Si, M.Eng.Sc", img: "{{ asset('images/dosen/paknazar.png') }}" , desc: "Ergonomics, Software Development", background: "anzaro[at]usk.ac.id" },
            { name: "Ir. Rahmad Dawood, S.Kom, M.Sc., IPM., ASEAN Eng. APEC Cr.", img: "{{ asset('images/dosen/pakrd.png') }}" , desc: "ICT4D, Internet of Things", background: "rahmad.dawood[at]usk.ac.id" },
            { name: "Kurnia Saputra, S.T, M.S", img: "{{ asset('images/dosen/pakkur.png') }}" , desc: "Software Eng., Mobile Technology", background: "kurnia.saputra[at]usk.ac.id" },
            { name: "Dalila Husna Yunardi, BSc, M.Sc", img: "{{ asset('images/dosen/miss.png') }}" , desc: "Software Eng., ICT4D", background: "dalila[at]usk.ac.id" },
            { name: "Viska Mutiawani, B.IT., M.IT.", img: "{{ asset('images/dosen/buviska.png') }}" , desc: "E-Learning, Data Mining", background: "viska.mw[at]usk.ac.id" },
            { name: "Rini Deviani, S.T., M.Eng", img: "{{ asset('images/dosen/burini.png') }}" , desc: "Software Engineering, e-Gov", background: "rini.deviani[at]usk.ac.id" },
            { name: "Mahyus Ihsan, S.Si., M.Si", img: "{{ asset('images/dosen/pakmahyus.png') }}" , desc: "Comp. Networking, Computer Graphics.", background: "mahyus[at]usk.ac.id" },
            { name: "Maulyanda, S.Tr.Kom., M.Kom", img: "{{ asset('images/dosen/pakmaulyanda.png') }}" , desc: "Software Engineering", background: "maulyanda[at]usk.ac.id" },
            { name: "Rinny Asasunnaja, M.Kom", img: "{{ asset('images/dosen/burinny.png') }}" , desc: "Software Engineering", background: "Rinny.asasunnaja[at]usk.ac.id" },
        ],
        dm: [
            { name: "Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech", img: "{{ asset('images/dosen/prof.png') }}" , desc: "AI, Machine Learning, Big Data", background: "taufik.abidin[at]usk.ac.id" },
            { name: "Dr. Muhammad Subianto, S.Si, M.Si", img: "{{ asset('images/dosen/paksubianto.png') }}" , desc: "Statistical Computing, Data Mining.", background: "subianto[at]usk.ac.id" },
            { name: "Ir. Irvanizam Zamanhuri, S.Si., M.Sc., IPM.", img: "{{ asset('images/dosen/paknizam.png') }}" , desc: "Soft Comp, Fuzzy & Neutrosophic Sets", background: "irvanizam.zamanhuri[at]usk.ac.id" },
            { name: "Dr. Zahnur Nurdin, S.Si, M.InfoTech", img: "{{ asset('images/dosen/pakzahnur.png') }}" , desc: "Mathematical Computing, Algorithms", background: "zahnur[at]usk.ac.id" },
            { name: "Alim Misbullah, S.Si., MS.", img: "{{ asset('images/dosen/pakalim.png') }}" , desc: "Speech Processing & Deep Learning", background: "misbullah[at]usk.ac.id" },
            { name: "Kikye Martiwi Sukiakhy, ST., M.Kom", img: "{{ asset('images/dosen/bukikye.png') }}" , desc: "Decision Support System, Info. System", background: "kikye.martiwi.sukiakhy[at]usk.ac.id" },
            { name: "Amalia Mabrina Masbar Rus, B.IT., MBIS.", img: "{{ asset('images/dosen/buamal.png') }}" , desc: "Web Dev., Spatio Temporal Data Mining", background: "amaliammr[at]usk.ac.id" },
            { name: "Laina Farsiah, S.Si., M.Sc.", img: "{{ asset('images/dosen/bulaina.png') }}" , desc: "Data Mining, Machine Learning", background: "lainafarsiah[at]usk.ac.id" },
            { name: "Fathia Sabrina, M.Inf.Tech", img: "{{ asset('images/dosen/bufathia.png') }}" , desc: "Data Mining/Data Science", background: "fathia.sabrina[at]usk.ac.id" },
            { name: "Fitria Nilamsari, M.Sc", img: "{{ asset('images/dosen/bufitria.png') }}" , desc: "Data Science", background: "fitrianilamsari[at]usk.ac.id" },
        ],
        jaringan: [
            { name: "Razief Perucha Fauzie Afidh, S.Si, M.Sc", img: "{{ asset('images/dosen/pakrazief.png') }}" , desc: "Computer Networking, Data Science", background: "razief[at]usk.ac.id" },
            { name: "Rasudin Abubakar, S.Si, M.Info.Tech", img: "{{ asset('images/dosen/pakrasudin.png') }}" , desc: "Cryptography, Data Security", background: "rasudin[at]usk.ac.idd" },
            { name: "Arie Budiansyah, ST., M.Eng", img: "{{ asset('images/dosen/pakarie.png') }}" , desc: "Data Communication, OS", background: "arie.b[at]usk.ac.id" },
            { name: "Zulfan Abdullah, S.Si, M.Sc", img: "{{ asset('images/dosen/pakzulfan.png') }}" , desc: "Computer Networking", background: "zulfan.abdullah[at]usk.ac.id" },
            { name: "Husaini Muhammad, S.ST., M.Sc.", img: "{{ asset('images/dosen/pakhusaini.png') }}" , desc: "Speech Proc. & Cloud Technology.", background: "husaini.muhammad[at]usk.ac.id" },
            { name: "Imam Andhika, M.Kom", img: "{{ asset('images/dosen/pakimam.png') }}" , desc: "Networking", background: "imamandhika14[at]usk.ac.id" },
        ],
        gis: [
            { name: "Dr. Muzailin Affan, S.Si, M.Sc", img: "{{ asset('images/dosen/pakmuzailin.png') }}" , desc: "GIS, Remote Sensing", background: "muzailin[at]usk.ac.id" },
            { name: "Dr. Nizamuddin, S.Si, M.Info.Sc", img: "{{ asset('images/dosen/paknizamuddin.png') }}" , desc: "Geospasial Data, GIS", background: "niz4muddin[at]usk.ac.id" },
            { name: "Muslim Amiren, S.Si., M.InfoTech", img: "{{ asset('images/dosen/pakmuslim.png') }}" , desc: "Big Data Analytics, Multimedia.", background: "muslim.amiren[at]usk.ac.id" },
            { name: "Ardiansyah A. Damhoeri, BSEE, M.Sc", img: "{{ asset('images/dosen/pakardian.png') }}" , desc: "GIS, Remote Sensing, Geospatial", background: "ardiansyah[at]usk.ac.id" },
            { name: "Sri Azizah Nazhifah, S.Kom., M.Sc", img: "{{ asset('images/dosen/busri.png') }}" , desc: "Geospatial Data, GIS", background: "sriazizah07[at]usk.ac.id" },
            { name: "Andriani Putri, M.Sc", img: "{{ asset('images/dosen/buandri.png') }}" , desc: "Geospatial Data, GIS", background: "andrianiputri[at]usk.ac.id" },
        ]
    };

    function showCategory(category) {
        const container = document.getElementById("dosen-container");
        container.innerHTML = "";
        dosenData[category].forEach(dosen => {
            const card = `
                <div class="bg-white p-4 rounded-lg shadow-md transform transition duration-300 hover:scale-105 flex flex-col items-center text-center min-h-[250px] w-full">
                    <img src="${dosen.img}" class="w-20 h-20 rounded-full mb-3">
                    <h3 class="text-lg font-semibold">${dosen.name}</h3>
                    <p class="text-sm text-gray-600">${dosen.desc}</p>
                    <p class="text-xs text-gray-500 mt-2">${dosen.background}</p>
                </div>
            `;
            container.innerHTML += card;
        });
    }

    // Tampilkan kategori pertama saat halaman dimuat
    document.addEventListener("DOMContentLoaded", () => showCategory('rpl'));
</script>

@endsection

