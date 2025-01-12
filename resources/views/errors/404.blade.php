@vite('resources/css/app.css')
<!DOCTYPE html>
<html>
<head>
    <title>404</title>
</head>
<body>
    <div class="flex min-h-full flex-col">
        <main class="mx-auto flex w-full max-w-7xl flex-auto flex-col justify-center px-6 py-24 sm:py-64 lg:px-8">
            <p class="text-base/8 font-semibold text-violet-400">404</p>
            <h1 class="mt-4 text-pretty text-5xl font-semibold tracking-tight text-gray-900 sm:text-6xl">Page not found</h1>
            <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Sorry, we couldn’t find the page you’re looking for.</p>
            <div class="mt-10">
                <a href="{{ route('dashboard') }}" class="text-sm/7 font-semibold text-violet-400"><span aria-hidden="true">&larr;</span> Back to home</a>
            </div>
        </main>
    </div>
</body>
</html>
