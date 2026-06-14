<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smoking Detection - Login</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="min-h-screen relative overflow-hidden">

  <!-- Background Image -->
  <div class="absolute inset-0">
    <img
      src="{{ asset('images/poliban.jpeg') }}"
      alt="POLIBAN Background"
      class="w-full h-full object-cover"
    >
  </div>

  <!-- Dark Overlay -->
  <div class="absolute inset-0 bg-gradient-to-br from-slate-950/80 via-slate-900/70 to-blue-950/70"></div>

  <div class="relative z-10 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 rounded-3xl overflow-hidden shadow-2xl border border-white/10 backdrop-blur-md bg-white/10">

      <!-- Left Side -->
      <div class="relative hidden lg:flex flex-col justify-between p-10 xl:p-14 text-white bg-gradient-to-br from-blue-700/40 to-slate-900/50">

        <div class="absolute inset-0 bg-black/20"></div>

        <div class="relative z-10">
          <div class="flex items-center gap-4 mb-10">
            <img src="{{ asset('images/logopoliban.png') }}" alt="Logo" class="w-16 h-16 object-contain bg-white rounded-2xl p-2 shadow-lg">
            <div>
              <h1 class="text-2xl font-extrabold tracking-wide">POLIBAN</h1>
              <p class="text-sm text-white/80">Politeknik Negeri Banjarmasin</p>
            </div>
          </div>

          <div class="max-w-md">
            <h2 class="text-4xl font-extrabold leading-tight mb-4">
              Sistem Monitoring Pelanggaran Merokok
            </h2>
            <p class="text-white/85 text-base leading-relaxed">
              Masuk untuk memantau kamera, melihat data pelanggaran, dan mengelola hasil deteksi rokok secara real-time melalui sistem berbasis web dan Raspberry Pi.
            </p>
          </div>
        </div>

        <div class="relative z-10 mt-10">
          <div class="grid grid-cols-3 gap-4 text-center">
            <div class="bg-white/10 border border-white/15 rounded-2xl p-4">
              <div class="text-2xl font-bold">AI</div>
              <div class="text-xs text-white/75 mt-1">YOLOv11n</div>
            </div>
            <div class="bg-white/10 border border-white/15 rounded-2xl p-4">
              <div class="text-2xl font-bold">RTSP</div>
              <div class="text-xs text-white/75 mt-1">Kamera Tapo</div>
            </div>
            <div class="bg-white/10 border border-white/15 rounded-2xl p-4">
              <div class="text-2xl font-bold">Web</div>
              <div class="text-xs text-white/75 mt-1">Laravel</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Side -->
      <div class="bg-white/90 backdrop-blur-xl p-6 sm:p-10 lg:p-12 flex items-center justify-center">
        <div class="w-full max-w-md">

          <!-- Mobile Logo -->
          <div class="flex justify-center mb-6 lg:hidden">
            <img src="{{ asset('images/logorri.png') }}" alt="Logo" class="w-20 h-20 object-contain bg-white rounded-2xl p-2 shadow-lg">
          </div>

          <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">Selamat Datang</h2>
            <p class="mt-2 text-slate-500">Silahkan masukkan akun operator Anda</p>
          </div>

          <div class="border-b border-slate-200 w-24 mx-auto mb-8"></div>

          <form action="/auth-login" method="POST" class="space-y-5">
            @csrf

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pengguna</label>
              <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                placeholder="Masukkan nama pengguna"
                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition"
                required
              >
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
              <input
                type="password"
                name="password"
                placeholder="Masukkan kata sandi"
                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition"
                required
              >
            </div>

            <button
              type="submit"
              class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 hover:scale-[1.01] transition duration-300"
            >
              Masuk
            </button>
          </form>

          <div class="mt-8 text-center text-xs text-slate-500">
            Sistem Monitoring Pelanggaran Merokok
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if($errors->has('login_error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ $errors->first("login_error") }}',
        position: 'top',
        toast: true,
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true,
        backdrop: false,
        customClass: {
          popup: 'animate__animated animate__fadeInDown'
        }
      });
    </script>
  @endif

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</body>
</html>