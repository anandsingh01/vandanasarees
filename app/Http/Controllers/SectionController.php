<?php

namespace App\Http\Controllers;
use App\Models\Category;
use DB;
use App\Models\Product;
use App\Models\Product_size;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\HttpFoundation\Response;


class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data['page_heading'] = 'Section';
        $data['categories'] = Section::orderBy('id', 'DESC')->get();
        return view('admin.section.index', $data);
    }

    public function create(Request $request)
    {

//        print_r($request->all());die;

        if (isset($request->name_slug)) {
            $slug = str_replace(' ', '-', strtolower($request->name));
        } else {
            $slug = str_replace(' ', '-', strtolower($request->name));
        }
        $data = [
            'slug' => $slug
        ];

        $category = Section::where('slug', $data['slug'])->count();
        $savecategory = new Section;
        if ($category <= 0) {
            $savecategory->slug = $data['slug'];

        } else {
            $savecategory->slug = $data['slug'] . '-' . rand(11, 99);
        }

        $savecategory->category_type = $request->category_type;
        $savecategory->category_name = $request->name;
        $savecategory->parent_id = 0;
        $savecategory->show_on_menu = $request->show_on_menu;
        $savecategory->show_on_homepage = $request->show_at_homepage;
        $savecategory->banner_text = $request->banner_text;
        $savecategory->meta_title = $request->meta_title;
        $savecategory->meta_description = $request->meta_description;

        if ($request->hasFile('image')) {
            $newimage = $request->file('image');

            // Define the path where you want to store the uploaded image
            // Define the path where you want to store the uploaded image
            $path = 'uploads/images';
            $path2 = 'uploads/images/webp';
            $uniqueimagename = rand(1111, 9999) . time();
            $uniqueimage_original = $uniqueimagename . '.' . $newimage->getClientOriginalExtension();

            $other_format_path = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2 . '/' . $uniqueimagename . '.webp');
            $complete_path = $path2 . '/' . $uniqueimagename . '.webp';

            $savecategory->image = $complete_path;

        }

        if ($request->hasFile('banner_image')) {
            $newimage = $request->file('banner_image');

            // Define the path where you want to store the uploaded image
            $path = 'uploads/images';
            $path2 = 'uploads/images/webp';
            $uniqueimagename = rand(1111, 9999) . time();
            $uniqueimage_original = $uniqueimagename . '.' . $newimage->getClientOriginalExtension();

            $other_format_path = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2 . '/' . $uniqueimagename . '.webp');
            $complete_path = $path2 . '/' . $uniqueimagename . '.webp';

            $savecategory->banner_image = $complete_path;

        }


        $savecategory->status = '1';
        if ($savecategory->save()) {
            return redirect()->back()->with('success', 'Section Saved');
        }
    }

    public function edit($id)
    {
        $data['page_heading'] = 'Section';
        $data['category'] = Section::find($id);
        return view('admin.section.edit', $data);
    }

    public function update(Request $request)
    {

        if (isset($request->slug)) {
            $slug = str_replace(' ', '-', strtolower($request->slug));
        } else {
            $slug = str_replace(' ', '-', strtolower($request->name));
        }
        $data = [
            'slug' => $slug
        ];

        $category = Section::where('id', $request->id)->where('slug', $data['slug'])->count();
        $savecategory = Section::find($request->id);

        $savecategory->category_name = $request->name;
        $savecategory->parent_id = 0;

        $savecategory->show_on_menu = $request->show_on_menu;
        $savecategory->show_on_homepage = $request->show_at_homepage;
        $savecategory->banner_text = $request->banner_text;
        $savecategory->meta_title = $request->meta_title;
        $savecategory->meta_description = $request->meta_description;

        if ($request->hasFile('banner_image')) {
            $newimage = $request->file('banner_image');

            // Define the path where you want to store the uploaded image
            $path = 'uploads/images';
            $path2 = 'uploads/images/webp';
            $uniqueimagename = rand(1111, 9999) . time();
            $uniqueimage_original = $uniqueimagename . '.' . $newimage->getClientOriginalExtension();

            $other_format_path = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2 . '/' . $uniqueimagename . '.webp');
            $complete_path = $path2 . '/' . $uniqueimagename . '.webp';

            $savecategory->banner_image = $complete_path;

        }


        if ($request->hasFile('image')) {
            $newimage = $request->file('image');

            // Define the path where you want to store the uploaded image
            $path = 'uploads/images';
            $path2 = 'uploads/images/webp';
            $uniqueimagename = rand(1111, 9999) . time();
            $uniqueimage_original = $uniqueimagename . '.' . $newimage->getClientOriginalExtension();

            $other_format_path = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2 . '/' . $uniqueimagename . '.webp');
            $complete_path = $path2 . '/' . $uniqueimagename . '.webp';

            $savecategory->image = $complete_path;

        }


        if ($request->hasFile('meta_image')) {
            $newimage = $request->file('meta_image');

            // Define the path where you want to store the uploaded image
            $path = 'uploads/images';
            $path2 = 'uploads/images/webp';
            $uniqueimagename = rand(1111, 9999) . time();
            $uniqueimage_original = $uniqueimagename . '.' . $newimage->getClientOriginalExtension();

            $other_format_path = $newimage->move($path, $uniqueimage_original);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($other_format_path);

            $encoded = $image->toWebp()->save($path2 . '/' . $uniqueimagename . '.webp');
            $complete_path = $path2 . '/' . $uniqueimagename . '.webp';

            $savecategory->meta_image = $complete_path;

        }

        if ($savecategory->save()) {
            return redirect(url('admin/section'));
        }
    }

    public function destroy($id)
    {
//        $delete = Section::where('id', $id)->delete();
        $productdelete = Product::where('brands_id', $id)->get();

        foreach ($productdelete as $products) {

            $productSize = Product_size::where('product_id', $products->id)->delete();
//            print_r($productSize);die;
            $productdelete = Product::where('brands_id', $id)->delete();
        }

        $delete = Section::where('id', $id)->delete();
//        die;

        if ($delete == 1) {
            $success = true;
            $message = "Deleted";
        } else {
            $success = true;
            $message = "not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function change_status(Request $request)
    {
        $category = Section::find($request->id);
        if ($request->status == '1') {
            $category->status = '1';

            if ($request->id <= 2) {
                $products = Product::where('section_id', '=', $request->id)->update(['status' => 1]);
            } else {
                $products = Product::where('brands_id', '=', $request->id)->update(['status' => 1]);
            }

        } else {

            if ($request->id <= 2) {
                $products = Product::where('section_id', '=', $request->id)->update(['status' => 0]);
            } else {
                $products = Product::where('brands_id', '=', $request->id)->update(['status' => 0]);
            }

            $category->status = '0';
        }
        $category->save();
        return response()->json(['success' => ' status change successfully.']);
    }

    public function show_on_homet_status(Request $request)
    {
//        print_r($request->all());die;
        $category = Section::find($request->id);
        $category->show_on_homepage = $request->status;

        $category->save();
        return response()->json(['success' => ' status change successfully.']);
    }

    private function checkUploadedFileProperties($extension, $fileSize)
    {
        $allowedExtensions = ['csv', 'jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx'];
        $maxFileSize = 5 * 1024 * 1024;

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            throw new \Exception('Invalid file extension. Allowed extensions are: ' . implode(', ', $allowedExtensions));
        }

        if ($fileSize > $maxFileSize) {
            throw new \Exception('File size exceeds the maximum allowed size of 5MB.');
        }
    }

    public function uploadCategoryContent(Request $request)
    {
        try {
            $file = $request->file('csv_file');

            if (!$file) {
                throw new \Exception('No file was uploaded', 400);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();

            // Check file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);

            // Define the upload path
            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            // Open and read the CSV file
            $file = fopen($filepath, "r");
            $importData_arr = array();
            $i = 0;

            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                if ($i == 0) {
                    $i++;
                    continue; // Skip the first row (header)
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file);

            $j = 0;
            foreach ($importData_arr as $importData) {
                try {
                    $imageUrl = $importData[3]; // Assuming the image URL is in the 4th column

                    // Extract file ID from Google Drive link
                    preg_match('/\/d\/(.+?)\//', $imageUrl, $matches);
                    if (!isset($matches[1])) {
                        throw new \Exception('Invalid Google Drive link');
                    }

                    $imageName = basename($imageUrl);
                    $imagePath = $this->downloadGoogleDriveImage($imageUrl, $imageName);

                    // Convert the image to WebP format
                    $webpImagePath = $this->convertToWebp($imagePath);

                    // Generate slug for the category
                    if (isset($importData[2])) {
                        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($importData[1])));
                    } else {
                        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($importData[1])));
                    }

                    // Check if the category (product) already exists
                    $categoryExists = Section::where('slug', $slug)->orWhere('category_name', $importData[1])->exists();

                    if ($categoryExists) {
                        // Skip if product/category is already uploaded
                        continue; // Skip to the next iteration of the loop
                    }

                    // Proceed to save the product if it doesn't exist
                    $saveSection = new Section;

                    $categoryCount = Section::where('slug', $slug)->count();
                    if ($categoryCount <= 0) {
                        $saveSection->slug = $slug;
                    } else {
                        $saveSection->slug = $slug . '-' . rand(11, 99);
                    }

                    $saveSection->category_name = $importData[1];
                    $saveSection->image = $webpImagePath;
                    $saveSection->save();

                    $j++;

                } catch (\Exception $e) {
                    return response()->json(['error' => "Error in row $j: " . $e->getMessage()], 500);
                }
            }


            // Return success message
            return response()->json(['message' => "$j records successfully uploaded"]);

        } catch (\Exception $e) {
            // Catch general errors, including invalid Google Drive links
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Download the image from Google Drive using the file URL and save it locally.
     *
     * @param string $fileUrl Google Drive file URL
     * @param string $fileName Name to save the file as
     * @return string Path to the downloaded file
     * @throws \Exception
     */
    private function downloadGoogleDriveImage($fileUrl, $fileName)
    {
        // Extract the file ID from the Google Drive URL
        preg_match('/\/d\/(.+?)\//', $fileUrl, $matches);
        if (!isset($matches[1])) {

            throw new \Exception('Invalid Google Drive link');
        }

        $fileId = $matches[1];
        $downloadUrl = "https://drive.google.com/uc?export=download&id=$fileId";

        // Set timeout to 60 seconds (adjust as needed)
        $timeoutSeconds = 120;

        // Download the image with extended timeout
        $response = Http::timeout($timeoutSeconds)->get($downloadUrl);
        if ($response->status() !== 200) {
            throw new \Exception('Failed to download image from Google Drive');
        }

        // Ensure the directory exists
        $directoryPath = 'uploads/images/';
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // Clean the filename (you can also use $fileId or a custom name)
        $cleanFileName = $fileId . '.jpg'; // You can change the extension based on your image type
        $filePath = $directoryPath . $cleanFileName;

        // Save the file
        file_put_contents($filePath, $response->body());

        return $filePath;
    }


    private function convertToWebp($imagePath)
    {
        // Define the target max size (200 KB)
        $maxFileSize = 200 * 1024; // 200KB in bytes

        // Get original image size
        $originalSize = filesize($imagePath);

        // If the image is already smaller than 200KB, just convert it to webp
        if ($originalSize <= $maxFileSize) {
            return $this->convertImageToWebp($imagePath);
        }

        // Resize the image if it's larger than 200KB
        list($width, $height) = getimagesize($imagePath);

        $imageType = mime_content_type($imagePath);

        switch ($imageType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Reduce the image dimensions proportionally
        $scale = sqrt($maxFileSize / $originalSize);
        $newWidth = $width * $scale;
        $newHeight = $height * $scale;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($imageType === 'image/png' || $imageType === 'image/gif') {
            imagecolortransparent($resizedImage, imagecolorallocatealpha($resizedImage, 0, 0, 0, 127));
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }

        // Resample the image
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image temporarily
        $tempResizedImagePath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/' . pathinfo($imagePath, PATHINFO_FILENAME) . '_resized.' . pathinfo($imagePath, PATHINFO_EXTENSION);

        // Save it based on image type
        switch ($imageType) {
            case 'image/jpeg':
                imagejpeg($resizedImage, $tempResizedImagePath, 85); // 85 is the quality, adjust as needed
                break;
            case 'image/png':
                imagepng($resizedImage, $tempResizedImagePath, 9); // 0 to 9 (9 being the highest compression)
                break;
            case 'image/gif':
                imagegif($resizedImage, $tempResizedImagePath);
                break;
        }

        // Destroy the image resources
        imagedestroy($image);
        imagedestroy($resizedImage);

        // Now convert the resized image to webp
        return $this->convertImageToWebp($tempResizedImagePath);
    }

    private function convertImageToWebp($imagePath)
    {
        $imageType = mime_content_type($imagePath);

        switch ($imageType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Save image as .webp
        $webpPath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/webp/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
        imagewebp($image, $webpPath, 90); // Quality is set to 90

        // Free up memory
        imagedestroy($image);

        // Delete the temporary image file
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $webpPath;
    }



}
