import './bootstrap';
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Handle edit button click
    document.querySelectorAll('.edit-comment-btn').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            document.querySelector(`#comment-${commentId} .comment-text`).classList.add('d-none');
            document.querySelector(`#comment-${commentId} .edit-comment-form`).classList.remove('d-none');
        });
    });

    // Handle cancel button click
    document.querySelectorAll('.cancel-edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.closest('.comment').getAttribute('id').split('-')[1];
            document.querySelector(`#comment-${commentId} .comment-text`).classList.remove('d-none');
            document.querySelector(`#comment-${commentId} .edit-comment-form`).classList.add('d-none');
        });
    });

    // Handle save button click
    document.querySelectorAll('.save-comment-btn').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            const commentText = this.previousElementSibling.value;
            const postId = this.closest('.comment').getAttribute('id').split('-')[1];

            fetch(`/posts/${postId}/comments/${commentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ text: commentText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`#comment-${commentId} .comment-text`).textContent = commentText;
                    document.querySelector(`#comment-${commentId} .comment-text`).classList.remove('d-none');
                    document.querySelector(`#comment-${commentId} .edit-comment-form`).classList.add('d-none');
                } else {
                    alert('Error updating comment.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-comment-btn').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            const postId = this.closest('.comment').getAttribute('id').split('-')[1];

            if (confirm('Are you sure you want to delete this comment?')) {
                fetch(`/posts/${postId}/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`#comment-${commentId}`).remove();
                    } else {
                        alert('Error deleting comment.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});


