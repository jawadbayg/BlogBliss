@extends('layouts.app')

@section('content')
<!-- Chat UI Container -->
<div class="container mt-4 col-8">
    <h2>AI Assistance</h2>
    <div class="chat-container">
        <div class="chat-box" id="chatBox">
            <!-- Messages will be appended here -->
        </div>
        <form id="chatForm" class="chat-form">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="message" id="message" placeholder="Enter your message" required>
            </div>
            <button type="submit" id="btn-AI">
    <i class="fa fa-paper-plane"></i>
</button>

        </form>
    </div>
    <button id="stopButton" class="btn btn-danger mt-2" style="display: none;">Stop</button>
    </div>
</div>

<div class="container mt-4 col-8">
    <h2>Write Post</h2>

    <form id="postForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" placeholder="Enter post title" required>
        </div>

        <div class="form-group">
            <label for="text">Text:</label>
            <textarea id="mytextarea" class="form-control" name="text" placeholder="Enter post text" required></textarea>
        </div>

        <div class="form-group d-flex justify-content-between" id="b-textarea">
            <div class="col-md-8 pr-2">
                <label for="tags">Tags:</label>
                <select name="tags[]" class="form-control" multiple>
                    <option value="science">Science</option>
                    <option value="technology">Technology</option>
                    <option value="art">Art</option>
                    <option value="fun">Fun</option>
                    <option value="education">Education</option>
                    <option value="kids">Kids</option>
                    <option value="business">Business</option>
                    <option value="selfImprovement">Self Improvement</option>
                    <option value="health">Health</option>
                </select>
            </div>

            <div class="col-md-4 pl-2">
                <label for="audience">Audience:</label>
                <select name="audience" class="form-control">
                    <option value="public">Public</option>
                    <option value="followers">Followers</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="post-create-btn">Submit</button>
    </form>

    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('posts.index') }}";
                    }
                });
            });
        </script>
    @endif
</div>

<!-- Include Froala Editor style -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<!-- Include Froala Editor JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new FroalaEditor('#mytextarea', {
        imageUploadURL: '{{ route('upload.froala') }}',
        imageUploadParams: {
            _token: '{{ csrf_token() }}' // Laravel's CSRF token
        },
    });

    document.getElementById('chatForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const userMessage = `<div class="chat-message user-message"><strong>You:</strong> ${formData.get('message')}</div>`;

    fetch('{{ route('flask.chat') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': formData.get('_token') // Pass CSRF token
        }
    })
    .then(response => response.json())
    .then(data => {
        const chatBox = document.getElementById('chatBox');
        const uniqueId = `response-${Date.now()}`; // Generate a unique ID for each response
        const botResponse = formatResponse(data.response);
        const botResponseContainer = `<div class="chat-message bot-response"><strong>AI:</strong> <span id="${uniqueId}" class="typing-container">${botResponse}</span></div>`;
        chatBox.innerHTML += userMessage + botResponseContainer;
        chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the bottom
        document.getElementById('message').value = ''; // Clear the input field

        // Show Stop button
        document.getElementById('stopButton').style.display = 'inline-block';

        // Apply typing animation to the bot's response
        typeText(uniqueId);
    })
    .catch(error => console.error('Error:', error));
});

function formatResponse(response) {
    let formattedResponse = response;
    formattedResponse = formattedResponse.replace(/^{\"response\":\"/, '');
    formattedResponse = formattedResponse.replace(/\"}$/, '');
    // Handle line breaks and bold text
    formattedResponse = formattedResponse.replace(/\\n/g, '<br>'); // For escaped newlines
    formattedResponse = formattedResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>'); // Bold text

    return formattedResponse;
}

let typingInterval;
function typeText(uniqueId) {
    const container = document.getElementById(uniqueId); // Get the specific response container by ID
    if (container) {
        const text = container.innerHTML;
        container.innerHTML = ''; // Clear the container before typing
        let index = 0;
        let typing = true;

        function type() {
            if (index < text.length && typing) {
                // Handle HTML tags while typing
                if (text.charAt(index) === '<') {
                    const tagEndIndex = text.indexOf('>', index);
                    container.innerHTML += text.substring(index, tagEndIndex + 1);
                    index = tagEndIndex + 1;
                } else {
                    container.innerHTML += text.charAt(index);
                    index++;
                }
                typingInterval = setTimeout(type, 50); // Adjust the typing speed here
            } else {
                typing = false;
                document.getElementById('stopButton').style.display = 'none'; // Hide the Stop button when done
            }
        }
        type();
    }
}

// Stop typing animation
document.getElementById('stopButton').addEventListener('click', function() {
    clearTimeout(typingInterval);
    document.querySelectorAll('.typing-container').forEach(container => {
        container.innerHTML = container.innerHTML; // Finalize and display the full text
    });
    this.style.display = 'none'; // Hide the Stop button
});
});
</script>

<style>
    .chat-container {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 400px; /* Adjust the height as needed */
    }
    .chat-box {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        background: #f9f9f9;
        border-bottom: 1px solid #ddd;
    }
    .chat-message {
        margin-bottom: 10px;
        padding: 5px;
        border-radius: 5px;
    }
    .user-message {
        background-color: #e1ffc7;
        text-align: left;
    }
    .bot-response {
        background-color: #e1e1e1;
        text-align: right;
    }
    .chat-form {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ddd;
        background: #fff;
    }
    .chat-form .form-group {
        flex: 1;
        margin-right: 10px;
    }
    .chat-form .btn {
        width: 100px;
    }
</style>

@endsection
