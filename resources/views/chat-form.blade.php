<!-- resources/views/chat-form.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Flask API</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .typing-container {
            border-right: 2px solid #000;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: black; }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Chat with Flask API</h2>
        <form id="chatForm" action="{{ route('flask.chat') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="message">Message:</label>
                <input type="text" class="form-control" name="message" id="message" placeholder="Enter your message" required>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>

        @if(session('response'))
            <div class="mt-4">
                <h3>Response:</h3>
                <div id="responseContainer">
                    <!-- Response will be inserted here -->
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const response = @json(session('response'));

            if (response) {
                const container = document.getElementById('responseContainer');
                const lines = response.response.split('\n');
                let html = '';

                lines.forEach(line => {
                    if (line.startsWith('**') && line.endsWith('**')) {
                        const heading = line.slice(2, -2).trim();
                        html += `<div class="heading typing-container">${heading}</div>`;
                    } else {
                        const content = line.trim();
                        html += `<div class="content typing-container">${content}</div>`;
                    }
                });

                container.innerHTML = html;
                typeText();
            }

            function typeText() {
                const typingContainers = document.querySelectorAll('.typing-container');
                typingContainers.forEach(container => {
                    const text = container.innerText;
                    container.innerHTML = '';
                    let index = 0;

                    function type() {
                        if (index < text.length) {
                            container.innerHTML += text.charAt(index);
                            index++;
                            setTimeout(type, 50);
                        }
                    }
                    type();
                });
            }
        });
    </script>
</body>
</html>
