<?php

namespace App\Http\Controllers\Admin\Header;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Carbon\Carbon;

class HeaderController extends Controller
{
    public function sliderList() 
    {
    	$slider_list = DB::table('sliders')->get();

    	return view('admin.header.slider.sliders', ['data' => $slider_list]);
    }

    public function sliderSetting($slider_id)
    {
        $slider = DB::table('sliders')->where('id',$slider_id)->first();
    	return view('admin.header.slider.slider_setting', compact('slider'));
    }

    public function sliderSettingUpdate(Request $request)
    {
        $request->validate([
            'slider_id' => 'required',
            'type' => 'required',
        ]);
        
        if ($request->input('type') == '1') {
            DB::table('sliders')->where('id',$request->input('slider_id'))
                ->update([
                    'show_text_type' => $request->input('type'),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
        } else {
            DB::table('sliders')->where('id',$request->input('slider_id'))
                ->update([                    
                    'show_text_type' => $request->input('type'),
                    'other_title' => $request->input('title'),
                    'bold_text' => $request->input('bold_text'),
                    'description' => $request->input('description'),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
        }
        return redirect()->route('admin.slider_list');   
    }
    public function showSliderForm() 
    {
    	return view('admin.header.slider.new_slider');
    }

    public function uploadSlider(Request $request)
    {
        $request->validate([
            'slider' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:width=1140,height=400',
        ]);

    	if ($request->hasFile('slider')) {
            $slider = $request->file('slider');
            $file   = time().'.'.$slider->getClientOriginalExtension();

            if(!File::exists(public_path()."/assets"))
                File::makeDirectory(public_path()."/assets");

            if(!File::exists(public_path()."/assets/slider"))
                File::makeDirectory(public_path()."/assets/slider");

            $destinationPath = public_path('/assets/slider');
            $img = Image::make($slider->getRealPath());
            $img->save($destinationPath.'/'.$file);

            DB::table('sliders')
                ->insert([
                 	'slider' => $file
            	]);
        }

        return redirect()->back()->with('msg', 'Slider has been added successfully');
    }

    public function deleteSlider($id)
    {
    	$slider_data = DB::table('sliders')
    		->where('id', $id)
    		->first();

    	File::delete(public_path('assets/slider/'.$slider_data->slider));

        DB::table('sliders')
        	->where('id', $id)
            ->delete();

        return redirect()->back();
    }

    public function showHeaderForm() 
    {
    	$colors = DB::table('header_section')->first();

    	return view('admin.header.header.update_header_color', ['colors' => $colors]);
    }

    public function headerUpdateColor(Request $request, $id)
    {

        $request->validate([
            'top_color' => 'required',
            'middle_color' => 'required',
            'word_color' => 'required',
            'header_top_title' => 'required',
            'header_title' => 'required',
            'header_call_no' => 'required',
            'header_email' => 'required',
            'footer_contact_info' => 'required',
            'privacy' => 'required',
            'footer_background_color' => 'required',
            'footer_word_color' => 'required',
            'sliding_product_writeup' => 'required',
            'footer_banner_writeup' => 'required',
        ]);

        $header_data = DB::table('header_section')
            ->where('id', $id)
            ->first();

        DB::table('header_section')
        	->where('id', $id)
            ->update([
                'header_top_color' => $request->input('top_color'),
                'header_middle_color' => $request->input('middle_color'),
                'header_word_color' => $request->input('word_color'),
                'header_top_title' => $request->input('header_top_title'),
                'header_title' => $request->input('header_title'),
                'header_call_no' => $request->input('header_call_no'),
                'header_email' => $request->input('header_email'),
                'footer_contact_info' => $request->footer_contact_info,
                'privacy' => $request->privacy,
                'footer_background_color' => $request->input('footer_background_color'),
                'footer_word_color' => $request->input('footer_word_color'),
                'sliding_product_writeup' => $request->input('sliding_product_writeup'),
                'footer_banner_writeup' => $request->footer_banner_writeup,
            ]);

        if ($request->hasFile('footer_first_banner_image')) {
            
            $request->validate([
                'footer_first_banner_image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:width=390,height=270',
            ]);

            $banner = $request->file('footer_first_banner_image');
            $file   = time().'.'.$banner->getClientOriginalExtension();

            if(!File::exists(public_path()."/assets"))
                File::makeDirectory(public_path()."/assets");

            if(!File::exists(public_path()."/assets/footer"))
                File::makeDirectory(public_path()."/assets/footer");
             
            $destinationPath = public_path('/assets/footer');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);
    
            File::delete(public_path('assets/footer/'.$header_data->footer_first_banner));

            DB::table('header_section')
                ->where('id', $id)
                ->update([ 
                    'footer_first_banner' => $file, 
                ]);
        }

        if ($request->hasFile('footer_second_banner_image')) {
            
            $request->validate([
                'footer_second_banner_image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:width=390,height=270',
            ]);
            
            $banner = $request->file('footer_second_banner_image');
            $file   = time().'k.'.$banner->getClientOriginalExtension();

            if(!File::exists(public_path()."/assets"))
                File::makeDirectory(public_path()."/assets");

            if(!File::exists(public_path()."/assets/footer"))
                File::makeDirectory(public_path()."/assets/footer");
             
            $destinationPath = public_path('/assets/footer');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);
    
            File::delete(public_path('assets/footer/'.$header_data->footer_second_banner));

            DB::table('header_section')
                ->where('id', $id)
                ->update([ 
                    'footer_second_banner' => $file, 
                ]);
        }

        if ($request->has('footer_banner_background_color')) {

            DB::table('header_section')
                ->where('id', $id)
                ->update([ 
                    'footer_banner_background_color' => $request->input('footer_banner_background_color'), 
                ]);
        }

        if ($request->has('footer_banner_word_color')) {

            DB::table('header_section')
                ->where('id', $id)
                ->update([ 
                    'footer_banner_word_color' => $request->input('footer_banner_word_color'), 
                ]);
        }

        return redirect()->back()->with('msg', 'Record has been updated');
    }
}
