<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Import & Export Excel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Optional: Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    Import & Export Data User (Excel)
                </div>

                <div class="card-body">

                    {{-- Alert sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Alert error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- {{-- FORM IMPORT --}}
                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Upload File Excel</label>
                            <input type="file" name="file" class="form-control" required>
                            <small class="text-muted">
                                Format: xlsx / xls
                            </small>
                        </div>
                    </form> -->
                            <!-- <button type="submit" class="btn btn-success">
                                Import Excel
                            </button> -->
                    <div class="d-flex gap-2">
                            <a href="{{ route('users.export') }}" class="btn btn-primary">
                                Export Excel
                            </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
