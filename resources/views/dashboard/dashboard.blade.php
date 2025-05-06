@extends('layouts.absensi')

@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                <img src="{{ asset('assets/img/avatar1.jpg') }}" alt="avatar" class="imaged w64 rounded">
            </div>
            <div id="user-info">
            @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
            @endif
                <h2 id="user-name">{{ $employee->name }}</h2>
                <span id="user-role">{{ $employee->position }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absensi && $absensi->photo_in)
                                        <img src="{{ asset('storage/uploads/absensi/' . $photo_in) }}" alt="" class="imaged w64 rounded-3">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Time-In</h4>
                                    <span>{{ $absensi != null ? $absensi->time_in : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absensi && $absensi->photo_out)
                                        <img src="{{ asset('storage/uploads/absensi/' . $photo_out) }}" alt="" class="imaged w64 rounded-3">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Time-Out</h4>
                                    <span>{{ $absensi != null && $absensi->time_out != null ? $absensi->time_out : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekap-absensi">
            <h3 class="badge bg-primary p-2 fw-bold mb-2">Monthly Attendance Recap</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card border border-success">
                        <div class="card-body text-center" style="padding: 16px; font-size: 26px;">
                            <span class="text-success mb-1" style="font-size: 8px; font-weight: 600;">Attendance</span>
                            <ion-icon name="briefcase-outline" class="text-success"></ion-icon>
                            <span class="badge bg-success p-1" style="font-size: 12px;">{{ $absensi_recap->attended }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border border-primary">
                        <div class="card-body text-center" style="padding: 16px; font-size: 26px;">
                            <span class="text-primary mb-1" style="font-size: 8px; font-weight: 600;">Permission</span>
                            <ion-icon name="book-outline" class="text-primary"></ion-icon>
                            <span class="badge bg-primary p-1" style="font-size: 12px;">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border border-warning">
                        <div class="card-body text-center" style="padding: 16px; font-size: 26px;">
                            <span class="text-warning mb-1" style="font-size: 8px; font-weight: 600;">Sick</span>
                            <ion-icon name="medkit-outline" class="text-warning"></ion-icon>
                            <span class="badge bg-warning p-1" style="font-size: 12px;">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border border-danger">
                        <div class="card-body text-center" style="padding: 16px; font-size: 26px;">
                            <span class="text-danger mb-1" style="font-size: 8px; font-weight: 600;">Late</span>
                            <ion-icon name="time-outline" class="text-danger"></ion-icon>
                            <span class="badge bg-danger p-1" style="font-size: 12px;">{{ $absensi_recap->lated }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                    @foreach ($photo_history as $history)
                        <li>
                            <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="images-outline"></ion-icon>
                            </div>
                                <div class="in">
                                    <div>{{ date("d-m-Y", strtotime($history->absensi_date)) }}</div>
                                    <span class="badge badge-success">{{ $history->time_in }}</span>
                                    <span class="badge badge-danger">{{ $history->time_out }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboards as $leaderboard)
                        <li>
                            <div class="item">
                                <img src="{{ asset('assets/img/avatar1.jpg') }}" alt="image" class="image">
                                <div class="in">
                                    <div>
                                    <span class="fw-bold">{{ $leaderboard->name }}</span><br>
                                    <span class="text-muted">{{ $leaderboard->position }}</span>
                                    </div>
                                    <span class="badge {{ $leaderboard->time_in < '08:00' ? 'bg-primary' : 'bg-danger' }}">{{ $leaderboard->time_in }}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
