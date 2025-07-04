@extends('layouts::student.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Startup/Tanlov</h1>
    </section>

    <!-- Card boshi -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Startup tanlov</h3>
        </div>
        <div class="card-body">
            <form id="startupForm" action="{{ route('student.startup') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Yutuq turi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="achievementType" class="form-label">
                            <i class="fas fa-trophy"></i> Yutuq turi
                        </label>
                        <select id="achievementType" name="type" class="form-control" required>
                            <option value="" disabled selected>Tanlang</option>
                            <option value="startup">Start up</option>
                            <option value="contest">Tanlovlar</option>
                        </select>
                        @if($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                        @endif
                    </div>

                    <!-- Darajasi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="level" class="form-label">
                            <i class="fas fa-layer-group"></i> Darajasi
                        </label>
                        <select id="level" name="criteria_id" class="form-control" required>
                            <option value="" disabled selected>Tanlang</option>
                            @foreach ($criterias as $criteria)
                            <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('criteria_id'))
                        <span class="text-danger">{{ $errors->first('criteria_id') }}</span>
                        @endif
                    </div>

                    <!-- Ishtirokchilar -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="participants" class="form-label">
                            <i class="fas fa-users"></i> Ishtirokchilar
                        </label>
                        <select id="participants" name="participant" class="form-control" required onchange="toggleTeamInputs()">
                            <option value="" disabled selected>Tanlang</option>
                            <option value="team">Jamoaviy</option>
                            <option value="individual">Yakkalik</option>
                        </select>
                        @if($errors->has('participant'))
                        <span class="text-danger">{{ $errors->first('participant') }}</span>
                        @endif
                    </div>

                    <!-- F.I.SH (agar jamoaviy tanlansa) -->
                    <div class="col-12 mb-3" id="teamMembers" style="display: none;">
                        <label for="teamMemberName" class="form-label"> <i class="fas fa-user"></i> F.I.SH </label>
                        <input type="text" id="teamMemberName" name="team_members" class="form-control" placeholder="Ishtirokchilar ismi, sharifi">
                        
                        @if($errors->has('team_members'))
                        <span class="text-danger">{{ $errors->first('team_members') }}</span>
                        @endif
                    </div>

                    <!-- O'tkazilgan joyi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="location" class="form-label">
                            <i class="fas fa-map-marker-alt"></i> O'tkazilgan joyi
                        </label>
                        <select id="location" class="form-control" name="location_id" required>
                            <option value="" disabled selected>Tanlang</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('location_id'))
                        <span class="text-danger">{{ $errors->first('location_id') }}</span>
                        @endif
                    </div>

                    <!-- Mavzusi -->
                    <div class="col-12 mb-3">
                        <label for="topic" class="form-label">
                            <i class="fas fa-lightbulb"></i> Mavzusi
                        </label>
                        <textarea id="topic" class="form-control" name="title" placeholder="Mavzuni kiriting" required></textarea>
                        @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Asos bo'luvchi hujjat -->
                    <div class="col-12 mb-3">
                        <label for="supportingDocument" class="form-label">
                            <i class="fas fa-file-upload"></i> Asos bo'luvchi hujjat
                        </label>
                        <input type="file" id="supportingDocument" name="file" class="form-control" required>
                        @if($errors->has('file'))
                        <span class="text-danger">{{ $errors->first('file') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Saqlash tugmasi -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Jadval: Yuklangan Yutuqlar Ro'yxati -->
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">Yuklangan Yutuqlar Ro'yxati</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Yutuq turi</th>
                        <th>Darajasi</th>
                        <th>Ishtirokchilar</th>
                        <th>O'tkazilgan joyi</th>
                        <th>Mavzusi</th>
                        <th>Fayl nomi</th>
                        <th>Holati</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->type() }}</td>
                        <td>{{ $item->criteria->name }}</td>
                        <td>{{ $item->team_members() }}</td>
                        <td>{{ $item->getLocation() }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{!! $item->file->download_tag() !!}</td>

                        <td><span class="badge badge-{{ $item->status()['color'] }}">{{ $item->status()['name'] }}</span></td>

                        @if($item->file->status == 'pending')
                        <td>
                            <form action="{{ route('student.startup.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> O'chirish</button>
                            </form>
                        </td>
                        @elseif($item->file->status == 'rejected')
                            <td>
                                <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="{{ $item->file->reject_reason }}">
                                    <i class="fa fa-eye fa-sm"></i>
                                </button>
                            </td>
                        @else
                        <td>
                            Bu fayl uchun harakat imkonsiz
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <!-- Qo'shimcha yutuqlar ma'lumotlari qo'shiladi -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
