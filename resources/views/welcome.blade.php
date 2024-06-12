<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Articles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .article-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark p-3 bg-dark">
        <a class="navbar-brand" href="#">News Articles</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#articles">Articles <span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <br> 
        {{-- heading from given api --}}
        <h2>{{ $heading['title'] }}</h2>
        <p>{{ $heading['description'] }}</p>
        <div class="row">
            <div class="col-md-6 mb-3">
                <a href="{{ $heading['link'] }}" class="text-center">Read More</a>
            </div>
            <div class="col-md-6 mb-3 d-flex justify-content-end">
                <span class=""><b>{{ $heading['lastBuildDate'] }}</b></span>
            </div>
        </div>
        <hr>
        {{-- all articels --}}
        <h1 class="mt-5 mb-3 text-center" id="articles">News Articles</h1>
<br>
        <div class="row ">
            <div class="col-md-3 col-5 mb-3">
                {{-- for sorting news according to user's preference i.e. oldest or newest --}}
                <form action="{{ route('news.index') }}" method="GET" class="mb-3">
                    <select name="sort" id="sort" class="form-control mr-2" onchange="this.form.submit()">
                        <option value="desc" {{ request()->query('sort') == 'desc' ? 'selected' : '' }}>Newest first
                        </option>
                        <option value="asc" {{ request()->query('sort') == 'asc' ? 'selected' : '' }}>Oldest first
                        </option>

                    </select>
                </form>
            </div>

            <div class="col-md-3 col-5 mb-3">
                {{-- searching news --}}
                <form action="{{ route('news.index') }}" method="GET" class="mb-3 ">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search articles"
                            value="{{ request()->query('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Publication Date & Time</th>
                        <th>Read More</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingIndex = ($articles->currentPage() - 1) * $articles->perPage() + 1;
                    @endphp
                    @foreach ($articles as $index => $article)
                        <tr>
                            <td>{{ $startingIndex + $index }}</td>
                            <td>
                                {{-- fetching image from api if image is not available then showing default 
                                not found image from public/assets folder --}}
                                <img src="{{ $article['enclosure']['@url'] }}" class="article-image"
                                    alt="Article Image" onerror="this.onerror=null; this.src='/assets/not_found.jpg';">
                            </td>
                            <td>{{ $article['title'] }}</td>
                            <td>
                                @if (!empty(strip_tags($article['description'])))
                                    {{-- removing the images and links from description and displying all in different fields 
                                for better user experience --}}
                                    {{ strip_tags($article['description']) }}
                                @else
                                    No description available
                                @endif
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime($article['pubDate'])) }}</td>
                            <td><a href="{{ $article['link'] }}" class="">Read more</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        {{-- pagination --}}
        <div class="d-flex justify-content-center">
            {{ $articles->onEachSide(1)->links('pagination::simple-bootstrap-4') }}
        </div>
    </div><br><br>

    {{-- footer --}}
    <footer class="bg-body-tertiary text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="https://mdbootstrap.com/">News API</a>
        </div>
    </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
