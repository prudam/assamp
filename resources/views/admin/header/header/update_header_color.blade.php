@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Color & Title Update & Other Info</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.header_update_color', ['id' => $colors->id]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="top_color">Header Top Color</label>
                            <input type="text" value="{{ $colors->header_top_color }}" name="top_color" id="top_color"  class="form-control col-md-7 col-xs-12">
                            @error('top_color')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="middle_color">Header Middle Color</label>
                            <input type="text" value="{{ $colors->header_middle_color }}" name="middle_color" id="middle_color"  class="form-control col-md-7 col-xs-12">
                            @error('middle_color')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="word_color">Word Color</label>
                            <input type="text" name="word_color" value="{{ $colors->header_word_color }}" id="word_color"  class="form-control col-md-7 col-xs-12">
                            @error('word_color')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="header_top_title">Header Top Title</label>
                            <input type="text" name="header_top_title" value="{{ $colors->header_top_title }}" class="form-control col-md-7 col-xs-12">
                            @error('header_top_title')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="header_title">Header Title</label>
                            <input type="text" name="header_title" value="{{ $colors->header_title }}" class="form-control col-md-7 col-xs-12">
                            @error('header_title')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="header_call_no">Header Call No/Whatsapp No</label>
                            <input type="text" name="header_call_no" value="{{ $colors->header_call_no }}" class="form-control col-md-7 col-xs-12">
                            @error('header_call_no')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="header_email">Header Email</label>
                            <input type="text" name="header_email" value="{{ $colors->header_email }}" class="form-control col-md-7 col-xs-12">
                            @error('header_email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="sliding_product_writeup">Sliding Product Writeup</label>
                            <input type="text" name="sliding_product_writeup" value="{{ $colors->sliding_product_writeup }}" class="form-control col-md-7 col-xs-12">
                            @error('sliding_product_writeup')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto">

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="footer_background_color">Footer Background Color</label>
                            <input type="text" name="footer_background_color" value="{{ $colors->footer_background_color }}" class="form-control col-md-7 col-xs-12">
                            @error('footer_background_color')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="footer_word_color">Footer Word Color</label>
                            <input type="text" name="footer_word_color" value="{{ $colors->footer_word_color }}" class="form-control col-md-7 col-xs-12">
                            @error('footer_word_color')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="footer_first_banner_image">Footer First Banner Image (390*270)</label>
                            <input type="file" name="footer_first_banner_image" class="form-control col-md-7 col-xs-12">
                            @error('footer_first_banner_image')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="footer_second_banner_image">Footer Second Banner Image  (390*270)</label>
                                <input type="file" name="footer_second_banner_image" class="form-control col-md-7 col-xs-12">
                                @error('footer_second_banner_image')
                                    {{ $message }}
                                @enderror
                            </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="footer_banner_background_color">Footer Banner Background Color</label>
                            <input type="text" name="footer_banner_background_color" value="{{ $colors->footer_banner_background_color }}" class="form-control col-md-7 col-xs-12">
                            @error('footer_banner_background_color')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="footer_banner_word_color">Footer Banner Word Color</label>
                                <input type="text" name="footer_banner_word_color" value="{{ $colors->footer_banner_word_color }}" class="form-control col-md-7 col-xs-12">
                                @error('footer_banner_word_color')
                                    {{ $message }}
                                @enderror
                            </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="footer_banner_writeup">Footer Banner Writeup</label>
                            <textarea class="form-control form-text-element ckeditor" name="footer_banner_writeup" required>
                                {!! $colors->footer_banner_writeup !!}
                            </textarea>
                            @error('footer_banner_writeup')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="footer_contact_info">Footer Address</label>
                                <textarea class="form-control form-text-element ckeditor" name="footer_contact_info" required>
                                    {!! $colors->footer_contact_info !!}
                                </textarea>
                                @error('footer_contact_info')
                                    {{ $message }}
                                @enderror
                            </div>
                    </div>
                </div>
                     
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="privacy">Privacy Policy</label>
                            <textarea class="form-control form-text-element ckeditor" name="privacy" required>
                                {!! $colors->privacy !!}
                            </textarea>
                            @error('privacy')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                  
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Upload</button>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
$('.ckeditor').ckeditor();
</script>
@endsection