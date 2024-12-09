<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-gray-800">Fungi's URL Shortener serivce</h1>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6" x-data="urlShortener()">
                        <div class="mb-8">
                            <form @submit.prevent="shortenUrl" class="space-y-4">
                                <div>
                                    <label for="url" class="block text-sm font-medium text-gray-700">Enter URL to shorten</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="url" name="url" id="url" x-model="longUrl" 
                                               class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                               placeholder="https://example.com/long/url">
                                        <button type="submit" 
                                                class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Shorten URL
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Results Section -->
                        <div x-show="shortUrl" x-cloak class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Shortened URL</h3>
                            <div class="flex items-center space-x-3">
                                <input type="text" x-model="shortUrl" readonly 
                                       class="flex-1 p-2 border rounded-md bg-white">
                                <button @click="copyToClipboard(shortUrl)"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                    Copy
                                </button>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div x-show="error" x-cloak 
                             class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                            <p x-text="error"></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function urlShortener() {
        return {
            longUrl: '',
            shortUrl: '',
            error: '',
            
            async shortenUrl() {
                this.error = '';
                this.shortUrl = '';
                
                try {
                    const response = await fetch('/api/encode', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ url: this.longUrl })
                    });
                    
                    const data = await response.json();
                    
                    if (!response.ok) {
                        throw new Error(data.error || 'Failed to shorten URL');
                    }
                    
                    this.shortUrl = data.short_url;
                } catch (err) {
                    this.error = err.message;
                }
            },
            
            async copyToClipboard(text) {
                try {
                    await navigator.clipboard.writeText(text);
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                }
            }
        }
    }
    </script>
</body>
</html>