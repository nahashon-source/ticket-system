<!-- resources/views/test.blade.php -->
<form method="POST" action="{{ route('test.patch') }}">
    @csrf
    @method('PATCH')
    <button type="submit">Test PATCH</button>
</form>
