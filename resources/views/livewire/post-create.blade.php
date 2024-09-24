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
            background-color: #DAE0E6;
            color: #1A1A1B;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 20px;
        }
        .post-form {
            background-color: #FFFFFF;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .form-label {
            font-weight: 500;
            color: #1A1A1B;
        }
        .form-control, .form-select {
            border-color: #EDEFF1;
            border-radius: 4px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0079D3;
            box-shadow: 0 0 0 2px rgba(0,121,211,0.2);
        }
        .btn-primary {
            background-color: #0079D3;
            border-color: #0079D3;
            font-weight: 700;
        }
        .btn-primary:hover {
            background-color: #005fa3;
            border-color: #005fa3;
        }
        .error {
            color: #FF4500;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="post-form">
            <h2 class="mb-4">Create a Post</h2>
            <form wire:submit.prevent="createPost">
                <div class="mb-3">
                    <label for="community" class="form-label">Select Community</label>
                    <select wire:model="community_id" id="community" class="form-select">
                        <option value="">Choose a community</option>
                        @foreach($communities as $community)
                            <option value="{{ $community->id }}">r/{{ $community->name }}</option>
                        @endforeach
                    </select>
                    @error('community_id') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" wire:model="title" id="title" class="form-control" placeholder="Enter your post title">
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea wire:model="body" id="body" class="form-control" rows="6" placeholder="Enter your post content"></textarea>
                    @error('body') <span class="error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
