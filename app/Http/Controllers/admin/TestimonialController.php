<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\helper;
use Illuminate\Support\Facades\Validator;
class TestimonialController extends Controller
{
   public function index(Request $request)
   { 
    if(Auth::user()->type == 4)
    {
        $vendor_id = Auth::user()->vendor_id;
    }else{
        $vendor_id = Auth::user()->id;
    }
    $testimonials = Testimonials::where('vendor_id',$vendor_id)->orderBy('reorder_id')->get();
      return view('admin.testimonial.index',compact('testimonials'));
   }
   public function add(Request $request)
   { 
      return view('admin.testimonial.add');
   }
   public function save(Request $request)
   {
     try {
        if (env('Environment') == 'sendbox') {
            return $this->sendError("This operation was not performed due to demo mode");
        }
        $validator = Validator::make($request->all(), [
            'image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [
            "image.image" => trans('messages.enter_image_file'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
        }
        if(Auth::user()->type == 4)
    {
        $vendor_id = Auth::user()->vendor_id;
    }else{
        $vendor_id = Auth::user()->id;
    }
       $testimonial= new Testimonials();
       $testimonial->vendor_id = $vendor_id;
       $testimonial->name = $request->name;
       $testimonial->position = $request->position;
       $testimonial->description = $request->description;
       $testimonial->star = $request->rating;
       if ($request->has('image')) {
           $testimonialimage = 'testimonial-' . uniqid() . "." .$request->file('image')->getClientOriginalExtension();
           $request->file('image')->move(storage_path('app/public/admin-assets/images/testimonials/'), $testimonialimage);
           $testimonial->image = $testimonialimage;
       }
       $testimonial->save();
       return redirect('admin/testimonials')->with('success', trans('messages.success'));
     } catch (\Throwable $th) {
        return redirect('admin/testimonials')->with('error', trans('messages.wrong'));
       
     }
      
   }
   public function edit(Request $request)
   { 
      $edittestimonial = Testimonials::where('id',$request->id)->first();
      return view('admin.testimonial.edit',compact('edittestimonial'));
   }
   public function update(Request $request)
   {
    try {
        if(Auth::user()->type == 4)
    {
        $vendor_id = Auth::user()->vendor_id;
    }else{
        $vendor_id = Auth::user()->id;
    }
    if (env('Environment') == 'sendbox') {
        return $this->sendError("This operation was not performed due to demo mode");
    }
    $validator = Validator::make($request->all(), [
        'image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
    ], [
        "image.image" => trans('messages.enter_image_file'),
    ]);
    if ($validator->fails()) {
        return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
    }
       $edittestimonial = Testimonials::where('id', $request->id)->first();
       $edittestimonial->vendor_id = $vendor_id;
       $edittestimonial->name = $request->name;
       $edittestimonial->position = $request->position;
       $edittestimonial->star = $request->rating;
       $edittestimonial->description = $request->description;
       if ($request->has('image')) {
           if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $edittestimonial->image))) {
               unlink(storage_path('app/public/admin-assets/images/testimonials/' . $edittestimonial->image));
           }
           $testimonialimage = 'testimonial-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
           $request->file('image')->move(storage_path('app/public/admin-assets/images/testimonials/'), $testimonialimage);
           $edittestimonial->image = $testimonialimage;
       }
       $edittestimonial->update();
       return redirect('admin/testimonials')->with('success', trans('messages.success'));
    } catch (\Throwable $th) {
       dd($th->getMessage());
    }
   
   }
   public function delete(Request $request)
    {
        $delete = Testimonials::where('id', $request->id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $delete->image))) {
            unlink(storage_path('app/public/admin-assets/images/testimonials/' . $delete->image));
        }
        $delete->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function reorder_testimonials(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $gettestimonial = Testimonials::where('vendor_id',$vendor_id )->get();
        foreach ($gettestimonial as $testimonial) {
            foreach ($request->order as $order) {
               $testimonial = Testimonials::where('id',$order['id'])->first();
               $testimonial->reorder_id = $order['position'];
               $testimonial->save();
            }
        }
        return response()->json(['status' => 1,'msg' => trans('messages.success')], 200);
    }
}