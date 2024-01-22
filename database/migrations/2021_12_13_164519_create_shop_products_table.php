use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsTable extends Migration
{
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_brand_id')->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku');
            $table->string('barcode');
            $table->longText('description');
            $table->bigInteger('qty');
            $table->bigInteger('security_stock');
            $table->boolean('featured');
            $table->boolean('is_visible');
            $table->decimal('old_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->enum('type', ['deliverable', 'downloadable']);
            $table->boolean('backorder');
            $table->boolean('requires_shipping');
            $table->date('published_at')->nullable();
            $table->string('seo_title', 60)->nullable();
            $table->string('seo_description', 160)->nullable();
            $table->decimal('weight_value', 10, 2)->nullable();
            $table->string('weight_unit');
            $table->decimal('height_value', 10, 2)->nullable();
            $table->string('height_unit');
            $table->decimal('width_value', 10, 2)->nullable();
            $table->string('width_unit');
            $table->decimal('depth_value', 10, 2)->nullable();
            $table->string('depth_unit');
            $table->decimal('volume_value', 10, 2)->nullable();
            $table->string('volume_unit');
            $table->timestamps();
        });

        // Add these lines to create the media library table
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_type', 'model_id']);
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('custom_properties')->nullable();
            $table->json('generated_conversions')->nullable();
            $table->json('manipulations')->nullable();
            $table->json('responsive_images')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop_products');
        Schema::dropIfExists('media');
    }
}
