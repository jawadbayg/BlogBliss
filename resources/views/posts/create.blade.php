@extends('layouts.app')

@section('content')
<!-- Chat UI Container -->
<div class="container mt-4 col-8">
    <h2>Write Blogs with AI</h2>
       
        <form id="chatForm" class="chat-form">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="message" id="message" placeholder="e.g,. write a 100 words blog on emerging technology" required>
            </div>
            <button type="submit" id="btn-AI">
    <i class="fa fa-paper-plane"></i>
</button>

        </form>
    
   
    </div>
</div>

<div class="container mt-1 col-8">
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
        <button id="stopButton" class="btn btn-danger mt-2" style="display: none;">Stop</button>

        <div class="form-group d-flex justify-content-between" id="b-textarea">
        <div class="col-md-8 pr-2">
    <label>Tags:</label>
    <div class="row">
        <!-- Column 1 -->
        <div class="col-md-6">
            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="science" id="tag-science" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-science">Science</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="technology" id="tag-technology" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-technology">Technology</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="art" id="tag-art" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-art">Art</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="fun" id="tag-fun" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-fun">Fun</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="education" id="tag-education" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-education">Education</label>
            </div>
        </div>

        <!-- Column 2 -->
        <div class="col-md-6">
            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="kids" id="tag-kids" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-kids">Kids</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="business" id="tag-business" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-business">Business</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="selfImprovement" id="tag-selfImprovement" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-selfImprovement">Self Improvement</label>
            </div>

            <div class="checkbox-wrapper-30 mb-2">
                <span class="checkbox">
                    <input type="checkbox" name="tags[]" value="health" id="tag-health" />
                    <svg>
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>
                <label for="tag-health">Health</label>
            </div>
        </div>
    </div>


</div>

  <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    <symbol id="checkbox-30" viewBox="0 0 22 22">
      <path fill="none" stroke="currentColor" d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2"/>
    </symbol>
  </svg>

<style>

</style>

<div class="col-md-4 pl-2">
    <label for="dropdown">Audience:</label>
    <div class="dropdown-btn">
        <input type="checkbox" id="dropdown-toggle" />

        <label class="dropdown__face" for="dropdown-toggle">
            <div class="dropdown__text">Select Audience</div>
            <div class="dropdown__arrow"></div>
        </label>

        <ul class="dropdown__items">
            <li data-value="public">Public</li>
            <li data-value="followers">Followers</li>
        </ul>

        <select name="audience" id="audience-select" style="display:none;">
            <option value="public">Public</option>
            <option value="followers">Followers</option>
        </select>
    </div>
</div>

<script>
document.querySelectorAll('.dropdown__items li').forEach(item => {
  item.addEventListener('click', () => {
    const selectedValue = item.getAttribute('data-value');
    document.querySelector('select[name="audience"]').value = selectedValue;
    document.querySelector('.dropdown__text').textContent = item.textContent;
    document.querySelector('#dropdown-toggle').checked = false;
  });
});
</script>

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


<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const froalaEditor = new FroalaEditor('#mytextarea', {
        imageUploadURL: '{{ route('upload.froala') }}',
        imageUploadParams: {
            _token: '{{ csrf_token() }}'
        },
    });

    let typingInterval; 
    let isTypingStopped = false; 

    document.getElementById('chatForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        const btnAI = document.getElementById('btn-AI');
        btnAI.disabled = true; 
        btnAI.style.backgroundColor = '#A9A9A9';

        fetch('{{ route('flask.chat') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token') 
            }
        })
        .then(response => response.json())
        .then(data => {
            const responseText = formatResponse(data.response);

            document.getElementById('stopButton').style.display = 'inline-block';

       
            isTypingStopped = false;

            typeTextInFroalaEditor(responseText, froalaEditor, btnAI);
             
        })
        .catch(error => {
            console.error('Error:', error);
            btnAI.disabled = false;
            btnAI.style.backgroundColor = ''; // Reset button color on error
        });
    });

    function formatResponse(response) {
        // Remove outer quotation marks and handle line breaks
        let formattedResponse = response
            .replace(/^{\"response\":\"/, '')
            .replace(/\"}$/, '')
            .replace(/\\n/g, '\n'); // Convert \n to actual newlines

        // Remove **bold** markers without embedding them
        formattedResponse = formattedResponse.replace(/\*\*(.*?)\*\*/g, '$1');

        return formattedResponse;
    }

    function typeTextInFroalaEditor(text, editor, btnAI) {
        let index = 0;

        function type() {
            if (index < text.length && !isTypingStopped) {
                let char = text.charAt(index);

                // Handle line breaks
                if (char === '\n') {
                    editor.html.insert('<br>', true); 
                    index++;
                } else {
                    editor.html.insert(char, true); 
                    index++;
                }

                typingInterval = setTimeout(type, 20); 
            } else {
                clearTimeout(typingInterval);
                document.getElementById('stopButton').style.display = 'none'; 
                btnAI.disabled = false;
                btnAI.style.backgroundColor = ''; // Reset button color
            }
        }

        type();
    }

    document.getElementById('stopButton').addEventListener('click', function() {
        clearTimeout(typingInterval);
        isTypingStopped = true; // Set the flag to true when typing is stopped
        this.style.display = 'none'; 
        document.getElementById('btn-AI').disabled = false; // Re-enable the button when stopped
        document.getElementById('btn-AI').style.backgroundColor = ''; // Reset button color
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
        height: 400px; 
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
