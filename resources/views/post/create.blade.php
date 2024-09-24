<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Post</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #f3ec78, #af4261);
            color: #1A1A1B;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            padding: 20px;
        }
        .post-form {
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 40px;
            transition: all 0.3s ease;
        }
        .post-form:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }
        h2 {
            color: #AF4261;
            font-weight: 700;
            font-size: 32px;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #333333;
            margin-bottom: 8px;
            display: block;
        }
        .form-control, .form-select {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #f9f9f9;
        }
        .form-control:focus, .form-select:focus {
            border-color: #AF4261;
            box-shadow: 0 0 10px rgba(175, 66, 97, 0.2);
            background-color: #fff;
        }
        .form-control:hover, .form-select:hover {
            border-color: #AF4261;
        }
        .btn-primary {
            background-color: #AF4261;
            border-color: #AF4261;
            font-weight: 600;
            border-radius: 8px;
            padding: 14px 24px;
            font-size: 18px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #F3EC78;
            color: #AF4261;
            box-shadow: 0 0 12px rgba(243, 236, 120, 0.5);
        }
        .error {
            color: #FF4500;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .image-preview {
            margin-top: 15px;
            text-align: center;
        }
        .image-preview img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }
        /* Custom File Input */
        .custom-file-input {
            display: none;
        }
        .custom-file-label {
            display: inline-block;
            padding: 12px 20px;
            cursor: pointer;
            background-color: #AF4261;
            color: #fff;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }
        .custom-file-label:hover {
            background-color: #F3EC78;
            color: #AF4261;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="post-form">
            <h2>Create a Post</h2>
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="community_id" class="form-label">Choose a community</label>
                    <select name="community_id" class="form-select" id="community_id" required>
                        <option value="">Select a community</option>
                        @foreach ($communities as $community)
                            <option value="{{ $community->id }}">r/{{ $community->name }}</option>
                        @endforeach
                    </select>
                    @error('community_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter your post title" required>
                    @error('title')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="body" class="form-label">Body</label>
                    <textarea name="body" class="form-control" id="body" rows="6" placeholder="Enter your post content" required></textarea>
                    @error('body')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Image (Optional)</label>
                    <label class="custom-file-label" for="image">Choose an image</label>
                    <input type="file" name="image" class="custom-file-input" id="image" accept="image/*">
                    <div id="imagePreview" class="image-preview"></div>
                    @error('image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        // Preview the image before submitting
        document.getElementById('image').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Clear previous previews

            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        // Update the custom file label with the selected file name
        document.getElementById('image').addEventListener('change', function(event) {
            const fileName = event.target.files[0] ? event.target.files[0].name : 'Choose an image';
            document.querySelector('.custom-file-label').textContent = fileName;
        });
    </script>
</body>
</html>
