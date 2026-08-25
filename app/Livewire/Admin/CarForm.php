<?php

namespace App\Livewire\Admin;

use Livewire\Component as LivewireComponent;
use Livewire\WithFileUploads;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarAvailabilityBlock;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class CarForm extends LivewireComponent
{
    use WithFileUploads;

    public ?Car $car = null;
    public $isEditMode = false;

    // SECTION 1 - Identity
    public $name = '';
    public $plate_number = '';
    public $brand = '';
    public $model = '';
    public $year;
    public $color = '#3B82F6';
    public $type = 'sedan';
    public $transmission = 'auto';
    public $seats = 5;
    public $fuel_type = 'petrol';

    // SECTION 2 - Price & Deposit
    public $price_per_day;
    public $price_per_week;
    public $deposit_amount;
    public $late_return_penalty;

    // SECTION 3 - Status & Display
    public $status = 'available';
    public $featured = false;
    public $availability_note;
    public $location;
    public $description;

    // SECTION 4 - Technical Records
    public $mileage;
    public $last_service_date;
    public $next_service_due;
    public $insurance_expiry;
    public $road_tax_expiry;

    // SECTION 5 - Images (Multi-upload)
    public $newImages = []; // Livewire uploads binding
    public $imagesList = []; // Holds items: ['id', 'url', 'is_primary', 'temp_path', 'image_path']
    public $deletedImageIds = [];

    // SECTION 6 - Block Availability
    public $blocksList = []; // Holds items: ['id', 'blocked_from', 'blocked_until', 'reason', 'is_new']
    public $newBlockFrom;
    public $newBlockUntil;
    public $newBlockReason;

    public $activeTab = 'general'; // general, images, blocks

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'plate_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('cars', 'plate_number')->ignore($this->car?->id)->whereNull('deleted_at'),
            ],
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 2),
            'color' => 'required|string|max:50',
            'type' => 'required|in:sedan,suv,mpv,pickup,van,hatchback',
            'transmission' => 'required|in:auto,manual',
            'seats' => 'required|integer|min:1|max:100',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            
            'price_per_day' => 'required|numeric|min:0',
            'price_per_week' => 'nullable|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'late_return_penalty' => 'nullable|numeric|min:0',

            'status' => 'required|in:available,rented,maintenance,hidden',
            'featured' => 'boolean',
            'availability_note' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',

            'mileage' => 'nullable|integer|min:0',
            'last_service_date' => 'nullable|date',
            'next_service_due' => 'nullable|date',
            'insurance_expiry' => 'nullable|date',
            'road_tax_expiry' => 'nullable|date',
        ];
    }

    protected $messages = [
        'name.required' => 'Display name is required.',
        'plate_number.required' => 'Plate number is required.',
        'plate_number.unique' => 'This plate number is already registered.',
        'brand.required' => 'Brand is required.',
        'model.required' => 'Model is required.',
        'year.required' => 'Year is required.',
        'year.integer' => 'Year must be a valid number.',
        'color.required' => 'Color is required.',
        'type.required' => 'Vehicle type is required.',
        'transmission.required' => 'Transmission is required.',
        'seats.required' => 'Number of seats is required.',
        'seats.integer' => 'Seats must be an integer.',
        'fuel_type.required' => 'Fuel type is required.',
        
        'price_per_day.required' => 'Daily rate is required.',
        'price_per_day.numeric' => 'Daily rate must be a number.',
        'deposit_amount.required' => 'Deposit amount is required.',
        'deposit_amount.numeric' => 'Deposit amount must be a number.',
        
        'status.required' => 'Status is required.',
    ];

    public function mount(?Car $car = null)
    {
        // Read URL query parameter for tab
        $tabParam = request()->query('tab');
        if (in_array($tabParam, ['general', 'images', 'blocks'])) {
            $this->activeTab = $tabParam;
        }

        if ($car && $car->exists) {
            $this->car = $car;
            $this->isEditMode = true;

            // Load data
            $this->name = $car->name;
            $this->plate_number = strtoupper($car->plate_number);
            $this->brand = $car->brand;
            $this->model = $car->model;
            $this->year = $car->year;
            $this->color = $car->color ?? '#3B82F6';
            $this->type = $car->type;
            $this->transmission = $car->transmission;
            $this->seats = $car->seats;
            $this->fuel_type = $car->fuel_type;

            $this->price_per_day = $car->price_per_day;
            $this->price_per_week = $car->price_per_week;
            $this->deposit_amount = $car->deposit_amount;
            $this->late_return_penalty = $car->late_return_penalty;

            $this->status = $car->status;
            $this->featured = (bool)$car->featured;
            $this->availability_note = $car->availability_note;
            $this->location = $car->location;
            $this->description = $car->description;

            $this->mileage = $car->mileage;
            $this->last_service_date = $car->last_service_date ? $car->last_service_date->format('Y-m-d') : null;
            $this->next_service_due = $car->next_service_due ? $car->next_service_due->format('Y-m-d') : null;
            $this->insurance_expiry = $car->insurance_expiry ? $car->insurance_expiry->format('Y-m-d') : null;
            $this->road_tax_expiry = $car->road_tax_expiry ? $car->road_tax_expiry->format('Y-m-d') : null;

            // Load existing images
            foreach ($car->images()->orderBy('sort_order')->get() as $img) {
                $this->imagesList[] = [
                    'id' => (string)$img->id,
                    'url' => $img->url,
                    'is_primary' => (bool)$img->is_primary,
                    'temp_path' => null,
                    'image_path' => $img->image_path,
                ];
            }

            // Load blocks
            foreach ($car->availabilityBlocks()->orderBy('blocked_from', 'desc')->get() as $block) {
                $this->blocksList[] = [
                    'id' => (string)$block->id,
                    'blocked_from' => $block->blocked_from->format('Y-m-d'),
                    'blocked_until' => $block->blocked_until->format('Y-m-d'),
                    'reason' => $block->reason,
                    'is_new' => false,
                ];
            }
        } else {
            $this->year = (int)date('Y');
            $this->location = Setting::get('default_location', 'Rawang, Selangor');
        }
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:10240|mimes:jpeg,png,jpg,webp', // 10MB max
        ], [
            'newImages.*.image' => 'File must be an image.',
            'newImages.*.max' => 'Image size cannot exceed 10MB.',
            'newImages.*.mimes' => 'Only JPEG, PNG, JPG, and WEBP formats are allowed.',
        ]);

        foreach ($this->newImages as $file) {
            if (count($this->imagesList) >= 10) {
                session()->flash('error', 'Maximum 10 images allowed per vehicle.');
                break;
            }

            // Store temporary upload on public disk to ensure persistence across Livewire requests
            $storedPath = $file->store('temp_uploads', 'public');
            $tempId = uniqid('temp_');
            
            $this->imagesList[] = [
                'id' => $tempId,
                'url' => asset('storage/' . $storedPath),
                'is_primary' => empty($this->imagesList), // set primary if first image
                'temp_path' => $storedPath,
                'image_path' => null,
            ];
        }

        $this->newImages = [];
    }

    // Set Primary Image
    public function setPrimaryImage($imageId)
    {
        $imageId = (string)$imageId;
        foreach ($this->imagesList as $key => $img) {
            $this->imagesList[$key]['is_primary'] = ((string)$img['id'] === $imageId);
        }
    }

    // Delete Image from list
    public function deleteImage($imageId)
    {
        $imageId = (string)$imageId;
        foreach ($this->imagesList as $key => $img) {
            if ((string)$img['id'] === $imageId) {
                // If it was a newly uploaded temp file, delete from disk
                if (!empty($img['temp_path']) && Storage::disk('public')->exists($img['temp_path'])) {
                    Storage::disk('public')->delete($img['temp_path']);
                }

                // If it's an existing DB image, track it for deletion on save
                if (!empty($img['image_path'])) {
                    $this->deletedImageIds[] = $img['id'];
                }

                unset($this->imagesList[$key]);
                break;
            }
        }

        // Re-index array
        $this->imagesList = array_values($this->imagesList);

        // If primary image was deleted, auto-assign first remaining image as primary
        $hasPrimary = false;
        foreach ($this->imagesList as $img) {
            if ($img['is_primary']) {
                $hasPrimary = true;
                break;
            }
        }

        if (!$hasPrimary && !empty($this->imagesList)) {
            $this->imagesList[0]['is_primary'] = true;
        }
    }

    // Move Image in order (left/right)
    public function moveImage($index, $direction)
    {
        $targetIndex = $index + $direction;

        if ($targetIndex < 0 || $targetIndex >= count($this->imagesList)) {
            return; // Out of bounds
        }

        $temp = $this->imagesList[$index];
        $this->imagesList[$index] = $this->imagesList[$targetIndex];
        $this->imagesList[$targetIndex] = $temp;
    }

    // SECTION 6 — Add blocked date range
    public function addBlock()
    {
        $this->validate([
            'newBlockFrom' => 'required|date',
            'newBlockUntil' => 'required|date|after_or_equal:newBlockFrom',
            'newBlockReason' => 'required|string|max:255',
        ], [
            'newBlockFrom.required' => 'Block start date is required.',
            'newBlockUntil.required' => 'Block end date is required.',
            'newBlockUntil.after_or_equal' => 'End date must be on or after start date.',
            'newBlockReason.required' => 'Block reason is required.',
        ]);

        $this->blocksList[] = [
            'id' => uniqid('temp_block_'),
            'blocked_from' => $this->newBlockFrom,
            'blocked_until' => $this->newBlockUntil,
            'reason' => $this->newBlockReason,
            'is_new' => true,
        ];

        // Reset fields
        $this->newBlockFrom = null;
        $this->newBlockUntil = null;
        $this->newBlockReason = null;
    }

    // Delete blocked date range
    public function deleteBlock($blockId)
    {
        $blockId = (string)$blockId;
        foreach ($this->blocksList as $key => $block) {
            if ((string)$block['id'] === $blockId) {
                // If it exists in DB, delete it directly
                if (!$block['is_new']) {
                    CarAvailabilityBlock::destroy($blockId);
                }
                unset($this->blocksList[$key]);
                break;
            }
        }
        $this->blocksList = array_values($this->blocksList);
    }

    // Submit Form
    public function save($redirect = true)
    {
        // Capitalize plate number
        $this->plate_number = strtoupper(trim($this->plate_number));

        // Clean empty string optional values to null
        if ($this->price_per_week === '') $this->price_per_week = null;
        if ($this->late_return_penalty === '') $this->late_return_penalty = null;
        if ($this->mileage === '') $this->mileage = null;
        if ($this->last_service_date === '') $this->last_service_date = null;
        if ($this->next_service_due === '') $this->next_service_due = null;
        if ($this->insurance_expiry === '') $this->insurance_expiry = null;
        if ($this->road_tax_expiry === '') $this->road_tax_expiry = null;
        if ($this->availability_note === '') $this->availability_note = null;
        if ($this->description === '') $this->description = null;
        if ($this->location === '') $this->location = null;

        $validatedData = $this->validate();

        // Check if there is at least one image when creating new
        if (!$this->isEditMode && empty($this->imagesList)) {
            session()->flash('error', 'Please upload at least one vehicle image.');
            $this->activeTab = 'images';
            return;
        }

        if ($this->isEditMode) {
            $car = $this->car;
            $car->update($validatedData);
            session()->flash('success', 'Vehicle details updated successfully.');
        } else {
            $car = Car::create($validatedData);
            session()->flash('success', 'New vehicle registered successfully.');
        }

        $carId = $car->id;

        // Process deleted images
        if (!empty($this->deletedImageIds)) {
            $imgsToDelete = CarImage::whereIn('id', $this->deletedImageIds)->get();
            foreach ($imgsToDelete as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
            $this->deletedImageIds = [];
        }

        // Process new & existing images
        $folder = "cars/{$carId}";
        Storage::disk('public')->makeDirectory($folder);

        foreach ($this->imagesList as $index => $imgData) {
            $sortOrder = $index + 1;
            $isPrimary = !empty($imgData['is_primary']);

            if (!empty($imgData['temp_path'])) {
                // Process newly uploaded file
                $tempPath = $imgData['temp_path'];
                $fullTempPath = storage_path('app/public/' . $tempPath);

                $fileName = uniqid() . '.webp';
                $relativePath = "{$folder}/{$fileName}";
                $destinationPath = storage_path("app/public/{$relativePath}");

                $savedSuccessfully = false;

                // Try Intervention Image optimization
                try {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($fullTempPath);
                    $image->scaleDown(width: 1200, height: 1200);
                    $image->toWebp(85)->save($destinationPath);
                    $savedSuccessfully = true;
                } catch (\Throwable $e) {
                    // Fallback to direct file copy if Intervention / GD encounters an issue
                    if (file_exists($fullTempPath)) {
                        $ext = pathinfo($tempPath, PATHINFO_EXTENSION) ?: 'jpg';
                        $relativePath = "{$folder}/" . uniqid() . ".{$ext}";
                        $destinationPath = storage_path("app/public/{$relativePath}");
                        @copy($fullTempPath, $destinationPath);
                        $savedSuccessfully = true;
                    }
                }

                if ($savedSuccessfully) {
                    CarImage::create([
                        'car_id' => $carId,
                        'image_path' => $relativePath,
                        'is_primary' => $isPrimary,
                        'sort_order' => $sortOrder,
                    ]);

                    // Clean up temp file
                    if (Storage::disk('public')->exists($tempPath)) {
                        Storage::disk('public')->delete($tempPath);
                    }
                }
            } elseif (!empty($imgData['image_path']) && is_numeric($imgData['id'])) {
                // Existing database image: update primary and sort order
                CarImage::where('id', $imgData['id'])->update([
                    'is_primary' => $isPrimary,
                    'sort_order' => $sortOrder,
                ]);
            }
        }

        // Process availability blocks (save new blocks)
        foreach ($this->blocksList as $blockData) {
            if (!empty($blockData['is_new'])) {
                CarAvailabilityBlock::create([
                    'car_id' => $carId,
                    'blocked_from' => $blockData['blocked_from'],
                    'blocked_until' => $blockData['blocked_until'],
                    'reason' => $blockData['reason'],
                ]);
            }
        }

        if ($redirect) {
            return redirect()->route('admin.cars.index');
        } else {
            // "Save & Add Another"
            $this->resetExcept(['color', 'type', 'transmission', 'seats', 'fuel_type', 'location']);
            $this->imagesList = [];
            $this->blocksList = [];
            $this->car = null;
            $this->isEditMode = false;
            $this->activeTab = 'general';
            session()->flash('success', 'Vehicle saved. You can now add the next vehicle.');
        }
    }

    public function render()
    {
        return view('livewire.admin.car-form');
    }
}
