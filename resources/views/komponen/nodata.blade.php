@if(session('error'))
    <div id="failedAlert" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
