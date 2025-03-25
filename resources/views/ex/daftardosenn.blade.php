<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftardosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    poppins: ["Poppins", "sans-serif"],
                    inter: ["Inter", "sans-serif"],
                    roboto: ["Roboto", "sans-serif"]
                },
            },
        },
    };
</script>
</head>
<body class="font-poppins min-h-screen flex flex-col bg-gray-100">

  <!-- Navbar -->
  @include('components/navbar')

  <div class="py-10 flex-grow">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <!-- Layout grid -->
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        
        <!-- Sidebar -->
        <aside class="hidden lg:col-span-3 lg:block xl:col-span-2">
          <nav aria-label="Sidebar" class="sticky top-4 mt-16 divide-y divide-gray-300">
            <div class="space-y-1 pb-8">
            <a href="#" class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                </svg>
                <span class="truncate">Home</span>
              </a>
              <a href="{{ route('profile') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <svg class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zM4.5 19.5a8.25 8.25 0 0115 0"></path>
            </svg>
            <span class="truncate">Profile</span>
            </a>
              <a href="{{ route('pengajuan') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"></path>
                </svg>
                <span class="truncate">Pengajuan</span>
              </a>
              <a href="{{ route('daftardosen') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
                <span class="truncate">Daftar Dosen</span>
              </a>
            </div>
            <div class="pt-10">
              <p class="px-3 text-sm font-medium text-gray-500">Menu Lain</p>
              <div class="mt-3 space-y-2">
                <a href="{{ route('panduan') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Panduan</a>
                <a href="{{ route('pengaturanakun') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Pengaturan Akun</a>
                <a href="{{ route('logout') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Logout</a>
              </div>
            </div>
          </nav>
        </aside>

      <!-- Main Content -->
      <main class="lg:col-span-9 xl:col-span-10">
          <!-- Tabs Section -->
          <div class="pt-16 px-4">
    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
        <li class="me-2">
            <a href="?tab=datamining" 
               class="inline-block p-4 rounded-t-lg 
               {{ request('tab') == 'datamining' || !request('tab') ? 'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' : 'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300' }}">
               Data Mining
            </a>
        </li>
        <li class="me-2">
            <a href="?tab=rpl" 
               class="inline-block p-4 rounded-t-lg 
               {{ request('tab') == 'rpl' ? 'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' : 'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300' }}">
               Rekayasa Perangkat Lunak
            </a>
        </li>
        <li class="me-2">
            <a href="?tab=gis" 
               class="inline-block p-4 rounded-t-lg 
               {{ request('tab') == 'gis' ? 'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' : 'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300' }}">
               Sistem Informasi Geografis
            </a>
        </li>
        <li class="me-2">
            <a href="?tab=jaringan" 
               class="inline-block p-4 rounded-t-lg 
               {{ request('tab') == 'jaringan' ? 'text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500' : 'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300' }}">
               Jaringan
            </a>
        </li>
    </ul>
</div>


<!-- Konten Tab -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    @if ($tab == 'datamining')
        <h2 class="text-2xl font-extrabold text-blue-900 dark:text-black-200 mb-2">Daftar Dosen Data Mining</h2>
        <!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/prof.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
                Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I completed my Ph.D. in Computer Science from North Dakota State University, USA, in 2006 under the supervision of Prof. Dr. William Perrizo and finished a Master degree in Computer Science from Royal Melbourne Institute of Technology, Australia, in 2000. I had been a Senior Software Engineer at Ask.com, one of the U.S. core search engine companies, developing algorithms and implementing efficient production-level programs to improve web search results. I was involved in developing utilities for usage mining and query understanding using Natural Language Processing (NLP).
            </p>

            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>Ph.D. in Computer Science from North Dakota State University, USA <br>
                    M.Tech. in Computer Science from Royal Melbourne Institute of Technology, Australia <br>
                    S.Si in Mathematics majoring informatics from ITS, Indonesia
                   <br>taufik.abidin[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

 <!-- Tabs Content -->
 <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/paksubianto.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Dr. Muhammad Subianto, S.Si, M.Si
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Dr. Muhammad Subianto is an associate professor at the Department of Informatics, Faculty of Mathematics and Natural Sciences, Syiah Kuala University Unsyiah. He completed a Ph.D. degree in Computer Science majoring Algorithmic Data Analysis from Universiteit Utrecht, the Netherlands, under the supervision of prof. dr. Arno Siebes and obtained a master degree in Statistical Computing from the IPB University, Indonesia. Dr. Subianto had been a vice director for financial affair at the Development of Higher Education (7 in 1 Project) Universitas Syiah Kuala, funded by Islamic Development Bank (IsDB), Saudi Fund for Development (SFD), and Government of Indonesia (G0I). He was involved in managing fund for developing the new FMIPA building.
            </p>

            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>Ph.D. in Information and Computing Sciences from Universiteit Utrecht, Nederland<br>
                    M.Si. in Statistics from the IPB University, Indonesia <br>
                    S.Si in Mathematics from ITS, Indonesia
                    <br>Email: subianto[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

 <!-- Tabs Content -->
 <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/paknizam.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Ir. Irvanizam Zamanhuri, S.Si., M.Sc., IPM.
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Irvanizam Zamanhuri is an associate professor at the Department of Informatics, Universitas Syiah Kuala, where he is Vice-Head of the department from 2014-2022. Since 2011 he is a Lab. Coordinator at the laboratory of Database and Data Mining.  Irvanizam Zamanhuri received a MSc degree in Computer Science from the Free University of Bozen-Bolzano (2010) and a BSc degree in Mathematics Science from Universitas Syiah Kuala (2002).  His current research interests include neutrosophic sets, decision support system, fuzzy sets and its application, multiple-attribute group decision making, and database applications in XML Data Structure. Those topics would be offered for diploma and bachelor students as their theses.  He is also author of publications in international journals and conference proceedings, many of which are indexed by Scopus (IEEE Access, Applied Computational Intelligence and Soft Computing, Axioms, Advances in Fuzzy Systems, IEEE, Heliyon, IREMOS, ICELTICs, CITSM, ICITEE, VLDB, ICAITI) and, according to Google Scholar and Scopus, has H-index 8 and 8 respectively. He regularly serves as reviewer for technical journals (↗Expert Systems with Applications (ScienceDirect), ↗Artificial Intelligence Review (SpringerLink), ↗Case Studies in Thermal Engineering (ScienceDirect), ↗Soft Computing (SpringerLink), ↗Journal of Computational and Applied Mathematics (ScienceDirect), ↗Machine Learning with Applications (ScienceDirect), ↗Mathematical Biosciences and Engineering (MBE), and international conference or organizer of conferences (↗SIBF(2021), ↗COSITE (2021), ↗ECONF (2021), ↗3ICT (2020), ↗DATA (2021, 2020), ↗SRC (2021, 2020), ↗FSDM (2021, 2020, 2019), JoCAI, ↗DASA (2021, 2020), ↗ICELTICs (2020, 2018, 2017), ↗ISAIC (2020), ↗ICONES (2019), ↗IEEE CYBERNETICSCOM (2019)).
            </p>

            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>PhD Student in Computer Science from Universitas Sumatera Utara, Indonesia<br>
                    M.Sc. in Computer Science from Free University of Bozen-Bolzano, Italy <br>
                    S.Si in Mathematics majoring informatics from Universitas Syiah Kuala, Indonesia
                   <br> Email: irvanizam.zamanhuri[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

 <!-- Tabs Content -->
 <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/buviska.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Viska Mutiawani, B.IT, M.IT
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I am one of lecturer in Informatics (Computer Science) Department at the Faculty of Mathematics and Natural Science of Syiah Kuala University, Banda Aceh. I received both B.IT. and M.IT. degree in Computer Science from Universiti Kebangsaan Malaysia (The National University of Malaysia) , Malaysia. I completed my bachelor degree in 2003 with final project related to Malay-English dictionary for mobile phone. Then I completed my master degree in 2007 with master thesis related to jawi image segmentation by using Voronoi diagram. My current researches are related to agricultural commodity system and learning programming application. In 2011 and 2014, I got “Dosen muda” research grant from Syiah Kuala university. And in 2017, I got “Penelitian produk terapan” research grant from Kemenristekdikti. The title of my current research is “Pengembangan aplikasi pembelajaran pemrograman menggunakan metode pemecahan masalah untuk meningkatkan pemahaman dasar pemrograman”. I’m also active in elearning program, so my current interests are educational application. For example application to learn programming, mathematics, physics.

            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.IT. in Information Technology from Universiti Kebangsaan Malaysia, Malaysisa<br>
                    B.IT in Information Technology from Universiti Kebangsaan Malaysia, Malaysisa <br>
                    Email: viska.mw[at]usk.ac.id
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

 <!-- Tabs Content -->
 <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakzahnur.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Dr. Zahnur Nurdin, S.Si, M.InfoTech
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I was born in Lageun district of West Aceh (now Aceh Jaya) on May 29, 1969. I completed primary education at SD Negeri Geuceu in 1982, junior high school at SMP Negeri 5 Banda Aceh (now SMPN 7) in 1985 and senior high school at SMA Negeri 3 Banda Aceh in 1988. In 1993 I completed my undergraduate study at the Mathematics Department of FMIPA ITS in Surabaya. Then in 2004 I completed a postgraduate study at the University of South Australia (UNISA) in the field of information technology. Since 1994 until now, I was appointed as a lecturer at the Faculty of Mathematics, Syiah Kuala University.
            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>Dr. in Mathematical Computing from Universitas Sumatera Utara, Indonesia<br>
                    M.Info.Tech. in Information Technology from the University of South Australia, Australia <br>
                    S.Si in Mathematics Science from ITS Surabaya, Indonesia
                    <br>Email: zahnur[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakalim.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Alim Misbullah, S.Si., MS.
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Alim Misbullah is a junior lecturer at the Department of Informatics, the Faculty of Mathematics and Natural Sciences, Universitas Syiah Kuala. He obtained a MSc degree at the Department of Electrical Engineering and Computer Science, National Chiao Tung University in 2015. From October 2015 until January 2019, he joined as an Senior Engineer at R&D DaVinci Innovation Lab, ASUSTek Computer Inc., Taipei, Taiwan.
            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>MS. in Electrical Engineering and Computer Science from National Chiao Tung University Taiwan<br>
                    S.Si in Mathematics Science from Universitas Syiah Kuala, Indonesia
                    <br>Email: misbullah[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>


<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/buamalya.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Amalia Mabrina Masbar Rus, B.IT., MBIS.
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I graduated from National University of Malaysia in 2007 for undergraduate degree in Management Information Systems. In 2013 I finished my master degree in Business Information System from Monash University Australia. In 2015 until present, I am a lecturer in Informatics Department. My research and area of interests are Data Mining, Web Development, and Spatio Temporal Data Mining. Currently I teach subjects such as Data Mining, Web Development, C Programming, Data Structure, Graph Theory, Logics, and Discrete Mathematics.
            <!-- Latar Belakang Pendidikan (Bold) -->
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>PhD Student in Applied Computer Science from Freiberg Technische Universitat Bergakademie, Germany<br>
                    M.BIS. in Business Information System from Monash University Australia
                    <br>B.IT in Management Information Systems from Universiti Kebangsaan Malaysia, Malaysisa</br>
                    <br>Email: amaliammr[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/bulaina.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Laina Farsiah, S.Si., M.Sc.
            </h3>

            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I joined as a lecturer at Informatics Department, Mathematics and Sciences Faculty, Syiah Kuala University in October 2020. I finished my master’s degree in Computer Science Department at National Tsing Hua University, Taiwan in 2015. I finish my bachelor’s degree in Mathematics Department, Syiah Kuala University in early 2012.

I am currently teaching several subjects such as Data Mining, Image Processing, Computer Vision, Programming Language, Data Structures and algorithms, and Graph Theory.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Sc. in Computer Science from National Tsing Hua University, Taiwan.<br>
                    S.Si. in Mathematics Science from Universitas Syiah Kuala, Indonesia
                    <br>Email: lainafarsiah[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
    @elseif ($tab == 'rpl')
    <h2 class="text-2xl font-extrabold text-blue-900 dark:text-black-200 mb-2">Daftar Dosen Rekayasa Perangkat Lunak</h2>
   <!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/paknazar.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Nazaruddin Abdullah, S.Si, M.Eng.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I am a lecturer at Informatics Management (Computer Science) Department,Syiah Kuala University.I graduated a Bachelor Degree (BSc) from Sepuluh Nopember Institute of Technology (ITS) Surabaya in 1996 at Faculty of Mathematics and Natural Sciences (FMIPA), MathematicsDepartment (Majoring in Informatics) and as full time lecturer in 1997 at Department of Mathematics FMIPA Syiah Kuala University. In 2006 I graduated a Master Degree (MEngSc) from Universiti Malaya,Malaysia, Department of Engineering Design and Manufacture (Major in Ergonomics-Applied Mathematics). Working experiences as lecturer are Head of Lab. Numerik (1998-1999), Head of Diploma (D3)of Informatics Management (2007-2012), Lecturer at Department of Informatics (2010-present), Head of Lab. Computer Network (2010-2011), Head of Lab. ICT, and additional tasks are as member of University Planning and Development (SP-4) in 2006 and asTeam Leader within 2007-2012, and as a Procurement Manager of Universitas Syiah Kuala (2013-2016). Additional working experiences out side the university are as Vocational Consultant (2006-2013) with GTZ/GIZ Germany, and as Experts at the Aceh Human Resources Development – LPSDM (2009-2012). Currently, I am Head of ICT Centre (2018-Present).
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.EngSc. in Engineering Design and Manufacture from Universiti Malaya, Malaysia<br>
                    S.Si in Mathematics majoring informatics from Sepuluh Nopember Institute of Technology (ITS) Surabaya, Indonesia
                    <br>Email: anzaro[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakrd.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Ir. Rahmad Dawood, S.Kom, M.Sc., IPM., ASEAN Eng. APEC Cr.
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Rahmad Dawood is Lecturer in the Department of Electrical and Computer Engineering, Faculty of Engineerign, Syiah Kuala Univesity; specifically in the area of Computer Engineering. From 2013, I have been appointed as the head of the Data Processing Laboratory in the Department of Electrical and Computer Engineering. Currently, He is also the chair (and one of the founding member) of Unsyiah’s Telematics Research Center (TRC) and Multimedia Learning Center (MLC).

My research interest resolves around: ICT4D (Information and Communication Technologies for Development) specifically technologies to support small and microenterprises, M4D (Mobile for Development) specifically Android-based applciations, IoT (Internet of Things) specifically applied to agriculture/livestocks/fishery, Health Informatics specifically in the area of electronic medical records, and eGovernment specifically to support government in the village level.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Sc. in Computer Science from Columbia University, USA<br>
                    S.Kom in Computer Engineering from ITS Surabaya, Indonesia
                    <br>Email: rahmad.dawood[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakkur.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Kurnia Saputra, S.T, M.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Kurnia Saputra is a lecturer at the Department of Informatics. He is the developer of web service technology for online tuition fee (SPP Online) and library in Syiah Kuala University. He is also a person in charge to maintain and develop the website of Career Development Center (CDC) of Syiah Kuala University. His research interests are mainly focused on Service Oriented Architecture (SOA), Mobile Application, Positioning and Tracking Technologies, and Software Architecture and Design. He earned his Bachelor degree in Electrical Engineering from Universitas Islam Sumatera Utara (UISU) Medan, North Sumatera in 2004 and received his M.Sc. degree in Computer Engineering from the University of Duisburg-Essen, Germany in 2011.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Sc. in Computer Engineering, University of Duisburg-Essen,Germany.<br>
                    S.T in Electrical Engineering from Universitas Islam Sumatera Utara (UISU), Indonesia
                    <br>Email: kurnia.saputra[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/miss.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Dalila Husna Yunardi, BSc, M.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I am a junior lecturer in the Department of Informatics, Faculty of Mathematics and Natural Sciences since 2014. I studied Computer Science majoring in Software Engineering in Universiti Tenaga Nasional, Malaysia and graduated in 2011. I went to do my postgraduate degree in Advanced Software Engineering in Leeds Beckett University. I got my master’s degree in 2013. My current research interests are in ICT4D and software engineering. Currently I am also a managing editor in Jurnal Natural, which is under my faculty as well as one of the deputy heads in Office of International Affairs.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Sc. in Computer Science majoring in Software Engineering, Leeds Beckett University, UK<br>
                    BSc in Software Engineering from Universiti Tenaga Nasional, Malaysia
                    <br>Email: dalilayunardi[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
    @elseif ($tab == 'gis')
    <h2 class="text-2xl font-extrabold text-blue-900 dark:text-black-200 mb-2">Daftar Dosen GIS</h2>
   <!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/paknizamuddin.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Dr. Nizamuddin, S.Si, M.Info.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Dr. Nizamuddin is a lecturer at Informatics Department, Faculty of Mathematics and Natural Sciences, Syiah Kuala University, Banda Aceh, Indonesia. He graduated a bachelor degree in mathematics science from ITS Surabaya, Indonesia and a master drogram in library, information and media studies or Information Sciences from University of Tsukuba, Japan with the tittle of thesis is Interactive web application for visualization of XML-based geo-chemical data. He also obtained a PhD in Information Sciences from University of Tsukuba, Japan with its title is A study of integrated environment for heterogeneous geograhphic information generated in tsunami recovery processes.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>Ph.D in Information Sciences from University of Tsukuba, Japan<br>
                    M.Info.Sc in Information Sciences from University of Tsukuba, Japan
                    <br>S.Si in Mathematics majoring informatics from Universitas Indonesia, Indonesia</br>
                    <br>Email: nizamuddin[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakmuzailin.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">  
             Dr. Muzailin Affan, S.Si, M.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Dr. Muzailin Affan is a lecturer at the Department of Informatics, Universitas Syiah Kuala. He graduated a PhD in Remote sensing from Tohoku University, Japan and obtained a master degree in Computer Science from Universiti Sains Malaysia, Malaysia. Before that, he also receive a bachelor degree in mathematics science majoring informatics at the ITS SUrabaya. His current research interests include remote sensing and Geographical Information System (GIS) that captures, store, analyzes, manages, and presents data that are linked to location.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>Dr. in Remote Sensing from Tohoku University, Japan<br>
                    M.Sc. in Computer Science from Universiti Sains Malaysia, Malaysia
                    <br>S.Si in Mathematics majoring informatics from ITS Surabaya, Indonesia</br>
                    <br>Email: muzailin[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakardian.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">  
            Ardiansyah A. Damhoeri, BSEE, M.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Ardiansyah obtained the Bachelor of Science in Electrical Engineering (S1) degree in 1996 from Purdue University, the United States. He later pursued Master (S2) study in the field of Geographical Information Science (GIS) in Universiti Sains Malaysia, Malaysia, where he awarded the Master of Science in GIS degree in 2007. His master thesis was entitled “The Development of an Open-source web-based GIS for Route Planning of Sightseeing Tour”, in which he combined web technology with GIS analysis. He continues to specialize in research on the web technology and GIS. He also teaches programming language as well as other courses related to GIS, Mapping and Remote Sensing.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Sc. in Geographical Information Science (GIS) from Universiti Sains Malaysia, Malaysia.<br>
                    BSEE in Electrical Engineering from Purdue University – West Lafayette, USA
                    <br>S.Si in Mathematics majoring informatics from ITS Surabaya, Indonesia</br>
                    <br>Email: ardiansyah[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
    @elseif ($tab == 'jaringan')
    <h2 class="text-2xl font-extrabold text-blue-900 dark:text-black-200 mb-2">Daftar Dosen GIS</h2>
   <!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakmahyus.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Mahyus Ihsan, S.Si, M.Si.
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I am a lecturer at the Mathematics Department of Faculty of Mathematics and Natural Science, Syiah Kuala University, Banda Aceh, Indonesia.I received my S,Si in mathematics (Informatics field) from Sepuluh Nopember Institute of Technology (ITS) Surabaya in 1997 and my M.Si in computer science from Bogor Agricultural Institute in 2006.

My teaching experiences since 1998 at some departments in Faculty of Mathematics and Natural Science and also in Faculty of Engineering. I have been taught some cources, such as Fundamental of Mathematics, Introduction to Information and Computer Technology, Programming Language in C, Computer Network System, Multimedia, Elementary Linear Algebra, Graph Theory, Human Computer Interaction, Computer Graphics, and Mathematical of Teaching and Learning Technology.

My research Interesting in some scopes in computer science and mathematic fields, especially graphical visualization and computing of graph theory, speech recognition, and mathematical of teaching and learning technology. In mathematical of teaching and learning technology field, I was created or developed the graphical user interface (GUI) and interactive problem-solving media of mathematical teaching and learning for graph theory course, such as determining the graph connectivity, tree labeling, algorithms for finding Hamiltonian Cycle and Eulerian Circuit, and finding the cycle/cyle-base of simple graph.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Si. in Computer Science from IPB University, Indonesia<br>
                    S.Si in Mathematics majoring informatics from Universitas Syiah Kuala, Indonesia
                    <br>Email: mahyus[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakrasudin.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Rasudin Abubakar, S.Si, M.Info.Tech
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I am a lecturer in the College of Science, Syiah Kuala University , Banda Aceh. I completed my Master degree (M.InfoTech) in Information Technology from the University Kebangsaan Malaysia , Malaysia, 2005 and my Bachelor degree (S.Si) in Mathematics Science (Informatics Stream) from Syiah Kuala University, Banda Aceh, 1997. I am a lecturer in the College of Science, Syiah Kuala University , Banda Aceh. I completed my Master degree (M.InfoTech) in Information Technology from the University Kebangsaan Malaysia , Malaysia, 2005 and my Bachelor degree (S.Si) in Mathematics Science (Informatics Stream) from Syiah Kuala University, Banda Aceh, 1997. I am a lecturer in the College of Science, Syiah Kuala University , Banda Aceh. I completed my Master degree (M.InfoTech) in Information Technology from the University Kebangsaan Malaysia , Malaysia, 2005 and my Bachelor degree (S.Si) in Mathematics Science (Informatics Stream) from Syiah Kuala University, Banda Aceh, 1997.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Info.Tech. in Information Technology from Universiti Kebangsaan Malaysia, Malaysia<br>
                    S.Si in Mathematics majoring informatics from Universitas Syiah Kuala, Indonesia
                    <br>Email: rasudin[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakrazief.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Razief Perucha Fauzie Afidh, S.Si, M.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Razief Perucha Fauzie Afidh is alecturer at the Department of Informatics, Universitas Syiah Kuala. He graduated with a Bachelor degree in Mathematics and Natural Sciences Faculty in 2007. In 2011 he completed my Master’s Degree Program in Communication and Media Engineering, University of Applied Science, Offenburg, Germany. He am currently a faculty member of Informatics Unsyiah since 2012 until now. He lead students in the field of Networking and Information, Communication and Technology for Development (ICT4D). Currently he is also involved in the development of several information systems based on Small, Medium and Micro Enterprises (MSMEs) in cooperation with various related parties.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>PhD Candidate in Computer Science from Universitas Indonesia, Indonesia<br>
                    M.Sc. in Communication and Media Engineering, University of Applied Science, Offenburg, Germany.
                    <br>S.Si in Mathematics majoring informatics from Universitas Syiah Kuala, Indonesia</br>
                    <br>Email: razief[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakarie.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Arie Budiansyah, ST., M.Eng
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            First of All, Arie Budiansyah started his study in Computer Engineering at Department of Electrical Engineering University of Syiah Kuala Banda Aceh, Indonesia since 1997 until 2014. He is also create LINUX club with his local friends and community to satisfying their interest on LINUX, network and hacking activities. at that time MiRC was famous application to share many hacking resources between community. at meantime year of 1999, he was selected as one of staff to maintenace campus network center. He is also actively in Laboratorium computer Network at his department. In 2004, after graduated from bachelor, Arie started job as IT Support at PT. Antar Mitra Prakarsa (M-Stars), one of private company in SMS Advertising Industry in Jakarta city Indonesia. He’s job involved such as monitoring, reporting and maintenance all hw, sw and SMS traffic 100% running and connected to GSM/CDMA operator server in data center. One of his activity was prepared SMS server such IBM, HP which has 8, 12 core processor, SATA Hardisk and remotely enable. In 2006, He stepped up new challenge by join with Glomobi Sdn. Bhd, one of Malaysia private company, founder by netherlander. This company also have same bussiness with his previuous company but the scope of SMS traffic coverage crossed country such New Zealand, Singapure, Malaysia, Indonesia, Brunei Darussalam and Thailand.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Eng. in Computer Science and Informatics Engineering, Asia University, Taiwan<br>
                    ST in Electrical Engineering from Universitas Syiah Kuala, Indonesia
                    <br>Email: arie.b[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakzulfan.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Zulfan Abdullah, S.Si, M.Sc
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            I am a lecturer at Department of Informatics Faculty of Mathematics and Natural Sciences, Syiah Kuala University (2015 – present). I completed my Bachelor degree in Mathematics, concentration of Computational Mathematics, Faculty of Mathematics and Natural Sciences of Syiah Kuala University, Banda Aceh, Indonesia in 2010. In 2013, completed my Master of Science (Information Technology) program, College of Arts & Sciences, Northern University of Malaysia, Malaysia. Areas of research interest are Computer Networking, Wireless Networking, Internet and Artificial Intelligence.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Sc. in Computer Science from Universiti Utara Malaysia, Malaysia<br>
                    S.Si in Mathematics Science from Universitas Syiah Kuala, Indonesia
                    <br>Email: zulfan.abdullah[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Tabs Content -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
    <div role="status" class="space-y-8 md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
        <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <!-- Gambar dengan object-cover untuk memenuhi area div -->
            <img src="{{ asset('images/dosen/pakhusaini.png') }}" alt="Image Description" class="w-full h-full object-cover rounded">
        </div>
        <div class="w-full">
            <!-- Nama Dosen (Lebih besar dan bold) -->
            <h3 class="text-xl font-extrabold text-blue-900 dark:text-black-200 mb-4">
            Husaini Muhammad, S.ST., M.Sc.
            </h3>
            <!-- Deskripsi Dosen -->
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            First of All, Arie Budiansyah started his study in Computer Engineering at Department of Electrical Engineering University of Syiah Kuala Banda Aceh, Indonesia since 1997 until 2014. He is also create LINUX club with his local friends and community to satisfying their interest on LINUX, network and hacking activities. at that time MiRC was famous application to share many hacking resources between community. at meantime year of 1999, he was selected as one of staff to maintenace campus network center. He is also actively in Laboratorium computer Network at his department. In 2004, after graduated from bachelor, Arie started job as IT Support at PT. Antar Mitra Prakarsa (M-Stars), one of private company in SMS Advertising Industry in Jakarta city Indonesia. He’s job involved such as monitoring, reporting and maintenance all hw, sw and SMS traffic 100% running and connected to GSM/CDMA operator server in data center. One of his activity was prepared SMS server such IBM, HP which has 8, 12 core processor, SATA Hardisk and remotely enable. In 2006, He stepped up new challenge by join with Glomobi Sdn. Bhd, one of Malaysia private company, founder by netherlander. This company also have same bussiness with his previuous company but the scope of SMS traffic coverage crossed country such New Zealand, Singapure, Malaysia, Indonesia, Brunei Darussalam and Thailand.
            <div class="space-y-2">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">
                    <strong>Educational Background:</strong>
                    <br>M.Eng. in Computer Science and Informatics Engineering, Asia University, Taiwan<br>
                    ST in Electrical Engineering from Universitas Syiah Kuala, Indonesia
                    <br>Email: arie.b[at]usk.ac.id</br>
                </p>
            </div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
   
    @else
    @endif
    </div>

       

          </div>
        </main>
      </div>
    </div>
  </div>

@include('components/footer')
</body>
</html>