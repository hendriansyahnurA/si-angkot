<div class="d-sm-flex align-items-center justify-content-between mb-4 px-4">
    <h1 class="h3 mb-0 text-gray-800">@yield('header-title', 'Dashboard')</h1>
    <span id="current-time" class="d-none d-sm-inline-block btn btn-sm text-white shadow-sm"
        style="background-color: #D0611B">
        <i class="fas fa-clock fa-sm text-white"></i>
        <span id="time-text"></span>
    </span>

</div>
<script>
    function updateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const formattedTime = now.toLocaleDateString('id-ID', options);
        document.getElementById('time-text').innerText = formattedTime;
    }

    updateTime();
    setInterval(updateTime, 1000);
</script>
