@extends('admin.layouts.master')
@push('styles')
    {{-- @include('admin.layouts.partials.styles-table') --}}
@endpush


@section('title')
    Trang Chủ
@endsection

@section('contents')
    <h1>Trang Chủ</h1>

    <div class="row">
        <!-- left column -->
        {{-- <div class="col-md-6"> --}}
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Quick Example</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="InputEmail">Email address</label>
                            <input type="email" class="form-control" id="InputEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="InputUserName">User Name</label>
                            <input type="text" class="form-control" id="InputUserName" placeholder="Enter User Name">
                        </div>

                        <div class="form-group">
                            <label for="InputPassword">Password</label>
                            <input type="password" class="form-control" id="InputPassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="InputFirstName">First Name</label>
                            <input type="text" class="form-control" id="InputFirstName" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="InputLastName">Last Name</label>
                            <input type="text" class="form-control" id="InputLastName" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="birthday">Ngày sinh:</label>
                            <div class="input-group date" id="birthday-datetimepicker">
                                <input type="text" class="form-control" name="birthday" id="birthday"
                                    value="{{ old('birthday') }}">
                                <div class="input-group-append" data-target="#birthday-datetimepicker"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @error('birthday')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="created_at">Ngày tạo:</label>
                            <div class="input-group date" id="created_at-datetimepicker" >
                                <input type="text" class="form-control datetimepicker-input" name="created_at"
                                    id="created_at" data-target="#created_at-datetimepicker"
                                    value="{{ old('created_at') }}">
                                <div class="input-group-append" data-target="#created_at-datetimepicker"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @error('created_at')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- input states -->
                        {{-- <div class="form-group">
                            <label class="col-form-label" for="inputSuccess"><i class="fas fa-check"></i> Input with
                                success</label>
                            <input type="text" class="form-control is-valid" id="inputSuccess" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputWarning"><i class="far fa-bell"></i> Input with
                                warning</label>
                            <input type="text" class="form-control is-warning" id="inputWarning" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> Input with
                                error</label>
                            <input type="text" class="form-control is-invalid" id="inputError" placeholder="Enter ...">
                        </div> --}}
                        {{-- textarea --}}
                        <div class="form-group">
                            <label>Textarea</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                        </div>
                        {{-- select --}}

                        <div class="form-group">
                            <label>Minimal (.select2-danger)</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                                style="width: 100%;">
                                {{-- <select class="form-control select2" disabled="disabled" style="width: 100%;"> --}}
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Multiple (.select2-purple)</label>
                            <div class="select2-purple"> {{-- Class to color --}}
                                <select class="select2" multiple="multiple" data-placeholder="Select a State"
                                    data-dropdown-css-class="select2-purple" style="width: 100%;">
                                    <option>Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option disabled="disabled">California (disabled)</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                        </div>

                        {{-- Input Mask --}}
                        <!-- Date dd/mm/yyyy -->
                        <div class="form-group">
                            <label>Date masks:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                    data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                            </div>
                            <!-- /.input group -->
                        </div>

                        <!-- Date mm/dd/yyyy -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                    data-inputmask-inputformat="mm/dd/yyyy" data-mask>
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <label>Internal phone mask:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="phone-input" name="phone"
                                    placeholder="Nhập số điện thoại"
                                    data-inputmask="'mask': ['0[0-9]{9,10}', '+84[0-9]{9,10}']" data-mask>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- /.input group -->
                        </div>

                        {{-- Date Tiem Pickup --}}
                        <!-- Date -->
                        <div class="form-group">
                            <label>Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <!-- Date and time -->
                        <div class="form-group">
                            <label>Date and time:</label>
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#reservationdatetime" />
                                <div class="input-group-append" data-target="#reservationdatetime"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->
                        <!-- Date range -->
                        <div class="form-group">
                            <label>Date range:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date and time range -->
                        <div class="form-group">
                            <label>Date and time range:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservationtime">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date and time range -->
                        <div class="form-group">
                            <label>Date range button:</label>

                            <div class="input-group">
                                <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                    <i class="far fa-calendar-alt"></i> Date range picker
                                    <i class="fas fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.form group -->

                        {{-- Color and time pickup --}}
                        <!-- Color Picker -->
                        <div class="form-group">
                            <label>Color picker:</label>
                            <input type="text" class="form-control my-colorpicker1">
                        </div>
                        <!-- /.form group -->

                        <!-- Color Picker -->
                        <div class="form-group">
                            <label>Color picker with addon:</label>

                            <div class="input-group my-colorpicker2">
                                <input type="text" class="form-control">

                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- time Picker -->
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label>Time picker:</label>

                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#timepicker" />
                                    <div class="input-group-append" data-target="#timepicker"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        </div>

                        {{-- file --}}
                        <div class="form-group">
                            <label for="InputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="InputFile">
                                    <label class="custom-file-label" for="InputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customFile">Custom File</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>

                        <!-- radio -->
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio">
                                <label for="customRadio1" class="custom-control-label">Custom Radio</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio"
                                    checked>
                                <label for="customRadio2" class="custom-control-label">Custom Radio
                                    checked</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio3" disabled>
                                <label for="customRadio3" class="custom-control-label">Custom Radio
                                    disabled</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio"
                                    id="customRadio4" name="customRadio2" checked>
                                <label for="customRadio4" class="custom-control-label">Custom Radio with custom
                                    color</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input
                                    class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                    type="radio" id="customRadio5" name="customRadio2">
                                <label for="customRadio5" class="custom-control-label">Custom Radio with custom
                                    color outline</label>
                            </div>
                        </div>
                        <!-- radio icheck -->
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="r1" checked>
                                <label for="radioPrimary1">
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="r1">
                                <label for="radioPrimary2">
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary3" name="r1" disabled>
                                <label for="radioPrimary3">
                                    Primary radio
                                </label>
                            </div>
                        </div>
                        <!-- radio icheck danger-->
                        <div class="form-group clearfix">
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="r2" checked id="radioDanger1">
                                <label for="radioDanger1">
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="r2" id="radioDanger2">
                                <label for="radioDanger2">
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="r2" disabled id="radioDanger3">
                                <label for="radioDanger3">
                                    Danger radio
                                </label>
                            </div>
                        </div>
                        <!-- radio icheck success-->
                        <div class="form-group clearfix">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r3" checked id="radioSuccess1">
                                <label for="radioSuccess1">
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r3" id="radioSuccess2">
                                <label for="radioSuccess2">
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r3" disabled id="radioSuccess3">
                                <label for="radioSuccess3">
                                    Success radio
                                </label>
                            </div>
                        </div>
                        <!-- checkbox -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox1"
                                    value="option1">
                                <label for="customCheckbox1" class="custom-control-label">Custom Checkbox</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox2" checked>
                                <label for="customCheckbox2" class="custom-control-label">Custom Checkbox
                                    checked</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox3" disabled>
                                <label for="customCheckbox3" class="custom-control-label">Custom Checkbox
                                    disabled</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger" type="checkbox"
                                    id="customCheckbox4" checked>
                                <label for="customCheckbox4" class="custom-control-label">Custom Checkbox with
                                    custom color</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input
                                    class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                    type="checkbox" id="customCheckbox5" checked>
                                <label for="customCheckbox5" class="custom-control-label">Custom Checkbox with
                                    custom color outline</label>
                            </div>
                        </div>
                        <!-- checkbox icheck -->
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxPrimary1" checked>
                                <label for="checkboxPrimary1">
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxPrimary2">
                                <label for="checkboxPrimary2">
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxPrimary3" disabled>
                                <label for="checkboxPrimary3">
                                    Primary checkbox
                                </label>
                            </div>
                        </div>
                        <!-- checkbox icheck red-->
                        <div class="form-group clearfix">
                            <div class="icheck-danger d-inline">
                                <input type="checkbox" checked id="checkboxDanger1">
                                <label for="checkboxDanger1">
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="checkbox" id="checkboxDanger2">
                                <label for="checkboxDanger2">
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="checkbox" disabled id="checkboxDanger3">
                                <label for="checkboxDanger3">
                                    Danger checkbox
                                </label>
                            </div>
                        </div>
                        <!-- checkbox icheck success-->
                        <div class="form-group clearfix">
                            <div class="icheck-success d-inline">
                                <input type="checkbox" checked id="checkboxSuccess1">
                                <label for="checkboxSuccess1">
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="checkbox" id="checkboxSuccess2">
                                <label for="checkboxSuccess2">
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="checkbox" disabled id="checkboxSuccess3">
                                <label for="checkboxSuccess3">
                                    Success checkbox
                                </label>
                            </div>
                        </div>
                        {{-- switch --}}
                        {{-- <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">Toggle this custom switch
                                    element</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3">Toggle this custom switch element
                                    with custom colors danger/success</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" disabled id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2">Disabled custom switch
                                    element</label>
                            </div>
                        </div> --}}
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->

    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">bs-stepper</h3>
                </div>
                <div class="card-body p-0">
                    <div class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#logins-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                    id="logins-part-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Logins</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#information-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="information-part" id="information-part-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Various information</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <!-- your steps content here -->
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                        placeholder="Password">
                                </div>
                                <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                            </div>
                            <div id="information-part" class="content" role="tabpanel"
                                aria-labelledby="information-part-trigger">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Visit <a href="https://github.com/Johann-S/bs-stepper/#how-to-use-it">bs-stepper documentation</a> for
                    more examples and information about the plugin.
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('scripts')
    {{-- @include('admin.layouts.partials.scripts-table') --}}
@endpush
