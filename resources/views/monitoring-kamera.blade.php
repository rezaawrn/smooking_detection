<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Monitoring Kamera</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-gray-200 font-sans">

<!-- CONTAINER -->
<div class="w-full min-h-screen border border-gray-400">

    <!-- FAKE BROWSER BAR -->
    <div class="bg-gray-300 px-4 py-2 border-b flex items-center gap-3">

        <div class="flex gap-2 text-gray-700">
            <i class="fas fa-arrow-left"></i>
            <i class="fas fa-arrow-right"></i>
            <i class="fas fa-rotate-right"></i>
        </div>

        <div class="flex-1">
            <div class="bg-white rounded-full px-4 py-1 text-sm border">
                https://website.com
            </div>
        </div>

        <div class="text-sm bg-white px-3 py-1 rounded border">
            A Web Page
        </div>

    </div>


    <!-- HEADER -->
    <div class="bg-gray-400 px-4 py-3 flex items-center justify-between">

        <div class="flex items-center gap-4">

            <div class="bg-white p-2 border">
                <i class="fas fa-bars"></i>
            </div>

            <div class="bg-white px-4 py-1 border rounded flex items-center gap-2">
                <i class="fas fa-user"></i>
                Operator
            </div>

        </div>

        <button class="bg-white px-4 py-1 border rounded">
            Logout
        </button>

    </div>


    <!-- BODY -->
    <div class="flex">

        <!-- SIDE ICON BAR -->
        <div class="w-20 bg-gray-500 min-h-screen flex flex-col items-center py-6 gap-6">

            <div class="bg-white w-12 h-12 flex items-center justify-center rounded shadow">
                <i class="fas fa-video text-xl"></i>
            </div>

            <div class="bg-white w-12 h-12 flex items-center justify-center rounded shadow">
                <i class="fas fa-book text-xl"></i>
            </div>

        </div>


        <!-- CONTENT -->
        <div class="flex-1 p-6">

            <!-- TITLE -->
            <h1 class="text-xl font-semibold mb-4">
                Live Pantauan Kamera
            </h1>


            <!-- VIDEO FRAME -->
            <div class="bg-white border-2 border-gray-400 rounded-xl p-4">

                <div class="w-full h-[400px] border-2 border-gray-500 rounded-lg flex items-center justify-center bg-gray-100">

                    <!-- PLACEHOLDER VIDEO -->
                    <div class="text-gray-400 text-lg">
                        STREAMING CAMERA
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
