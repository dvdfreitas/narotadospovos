<div>
    <form action="{{ route('language.switch') }}" method="POST">
        @csrf

        <select name="language" id="language" onchange="this.form.submit()">
            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇬🇧</option>
            <option value="pt" {{ app()->getLocale() === 'pt' ? 'selected' : '' }}>🇵🇹</option>
        </select>
    </form>
</div>
