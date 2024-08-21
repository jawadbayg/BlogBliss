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
    
    <button id="stopButton" class="btn btn-danger mt-2" style="display: none;">Stop</button>
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

        <div class="form-group d-flex justify-content-between" id="b-textarea">
        <div class="col-md-8 pr-2">
    <label>Tags:</label>
    <div class="tags-checkboxes">
        <!-- Science Checkbox -->
        <div class="checkbox-wrapper-30 ">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="science" id="tag-science" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-science">Science</label>
        </div>

        <!-- Technology Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="technology" id="tag-technology" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-technology">Technology</label>
        </div>

        <!-- Art Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="art" id="tag-art" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-art">Art</label>
        </div>

        <!-- Fun Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="fun" id="tag-fun" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-fun">Fun</label>
        </div>

        <!-- Education Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="education" id="tag-education" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-education">Education</label>
        </div>

        <!-- Kids Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="kids" id="tag-kids" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-kids">Kids</label>
        </div>

        <!-- Business Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="business" id="tag-business" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-business">Business</label>
        </div>

        <!-- Self Improvement Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
            <span class="checkbox">
                <input type="checkbox" name="tags[]" value="selfImprovement" id="tag-selfImprovement" />
                <svg>
                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                </svg>
            </span>
            <label for="tag-selfImprovement">Self Improvement</label>
        </div>

        <!-- Health Checkbox -->
        <div class="checkbox-wrapper-30 mt-1">
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

        <!-- Hidden select element for form submission -->
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

<!-- Include Froala Editor style -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<!-- Include Froala Editor JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const froalaEditor = new FroalaEditor('#mytextarea', {
    imageUploadURL: '{{ route('upload.froala') }}',
    imageUploadParams: {
      _token: '{{ csrf_token() }}' // Laravel's CSRF token
    },
  });

  document.getElementById('chatForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

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
        const responseText = formatResponse(data.response);

        // Show Stop button
        document.getElementById('stopButton').style.display = 'inline-block';

        // Apply typing animation to the Froala editor
        typeTextInFroalaEditor(responseText, froalaEditor);
      })
      .catch(error => console.error('Error:', error));
  });

  function formatResponse(response) {
    let formattedResponse = response;
    formattedResponse = formattedResponse.replace(/^{\"response\":\"/, '');
    formattedResponse = formattedResponse.replace(/\"}$/, '');
    // Handle line breaks and bold text (unchanged)
    formattedResponse = formattedResponse.replace(/\\n/g, '<br>'); // For escaped newlines
    formattedResponse = formattedResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>'); // Bold text

    return formattedResponse;
  }

  function typeTextInFroalaEditor(text, editor) {
    editor.html.set(''); // Clear the editor before typing

    let index = 0;
    let typingInterval;

    function type() {
      if (index < text.length) {
        let char = text.charAt(index);

        // Handle line breaks
        if (char === '\n') {
          editor.html.insert('<br>', true); // Insert line break with <br>
          index++;
        } else {
          editor.html.insert(char, true); // Insert character
          index++;
        }

        typingInterval = setTimeout(type, 50); // Adjust typing speed if needed
      } else {
        clearTimeout(typingInterval);
        document.getElementById('stopButton').style.display = 'none'; // Hide the Stop button when done
      }
    }

    type();
  }

  document.getElementById('stopButton').addEventListener('click', function() {
    clearTimeout(typingInterval);
    const editor = froalaEditor;
    editor.html.set(froalaEditor.html.get()); 
    this.style.display = 'none'; 
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
