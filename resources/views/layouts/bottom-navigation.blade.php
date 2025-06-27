<div class="appBottomMenu">
    <a href="/dashboard" class="item @php echo
        request()->is('dashboard') ? 'active' : ''
    @endphp">
        <div class="col">
        <ion-icon name="home-outline"></ion-icon>
            <strong>Dashboard</strong>
        </div>
    </a>
    <a href="#" class="item @php
        echo request()->is('calender') ? 'active' : ''
    @endphp">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
            aria-label="calendar outline"></ion-icon>
            <strong>Calendar</strong>
        </div>
    </a>
    <a href="/absensi" class="item">
        <div class="col">
            <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="#" class="item">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
            aria-label="document text outline"></ion-icon>
            <strong>Docs</strong>
        </div>
    </a>
    <a href="/editprofile" class="item @php echo
        request()->is('editprofile') ? 'active' : ''
    @endphp" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
