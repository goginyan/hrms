@extends('layouts.dashboard')

@section('title','Taxes')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('taxes.update', [$tax->id])}}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $tax->name }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback d-block">
                                    {{$errors->first('name')}}
                                </div>
                            @endif
                        </div>
                        <hr>
                        <h4>Intervals</h4>
                        <div class="intervals-container">
                            @php($counter = 0)
                            @foreach($tax->taxIntervals as $interval)
                                <div class="row interval-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="interval.start">Start</label>
                                            <input type="number" name="intervals[{{$counter}}][start]"
                                                   id="interval.start" value="{{$interval->start}}" min="0"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="interval.end">End</label>
                                            <input type="number" name="intervals[{{$counter}}][end]" id="interval.end"
                                                   value="{{$interval->end}}" min="0" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="interval.rate">Rate</label>
                                            <input type="number" name="intervals[{{$counter++}}][rate]"
                                                   id="interval.rate" value="{{$interval->rate}}" min="0"
                                                   class="form-control" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="d-block">&nbsp;</label>
                                        <button class="remove-btn"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <button id="add-interval-btn"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var intervalsCount = {{$counter}};
        $(document).ready(function () {
            $('#add-interval-btn').click(function (e) {
                e.preventDefault();

                let inretvalRow = '<div class="row interval-row">\n' +
                    '                                <div class="col-md-4">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <label for="interval.start">Start</label>\n' +
                    '                                        <input type="number" name="intervals[%d][start]" id="interval.start" value="0" min="0" class="form-control">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-md-4">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <label for="interval.end">End</label>\n' +
                    '                                        <input type="number" name="intervals[%d][end]" id="interval.end" value="0" min="0" class="form-control">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-md-2">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <label for="interval.rate">Rate</label>\n' +
                    '                                        <input type="number" name="intervals[%d][rate]" id="interval.rate" value="0" min="0" class="form-control" step="0.01">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-md-2">\n' +
                    '                                    <label class="d-block">&nbsp;</label>\n' +
                    '                                    <button class="remove-btn"><i class="fa fa-minus"></i></button>\n' +
                    '                                </div>\n' +
                    '                            </div>';

                inretvalRow = inretvalRow.replace(/%d/g, intervalsCount++);

                $('.intervals-container').append(inretvalRow);
            });

            $('.intervals-container').on('click', '.remove-btn', function (e) {
                e.preventDefault();

                if ($(this).closest('.intervals-container').find('.interval-row').length > 1) {
                    $(this).closest('.interval-row').remove();
                }
            });

        });
    </script>
@endpush
@push('style')
    <style>
        #add-interval-btn {
            background-color: #fff;
            border: 2px solid #3c8cbc;
            color: #3c8cbc;
            border-radius: 20px;
            line-height: normal;
            width: 35px;
            height: 35px;
        }

        #add-interval-btn:focus {
            outline: none;
        }

        .remove-btn {
            background-color: #fff;
            border: 2px solid #dd4b39;
            color: #dd4b39;
            border-radius: 20px;
            line-height: normal;
            width: 35px;
            height: 35px;
        }

        .remove-btn:focus {
            outline: none;
        }
    </style>
@endpush