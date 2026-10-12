
    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;

    Route::get('/product', [ProductController::class, 'index'])->middleware('permission:product.view')->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->middleware('permission:product.create')->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->middleware('permission:product.create')->name('product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->middleware('permission:product.view')->name('product.show');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->middleware('permission:product.edit')->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->middleware('permission:product.edit')->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->middleware('permission:product.delete')->name('product.destroy');


    Route::get('/product/search/{query}', [ProductController::class, 'search'])->name('product.search');
    Route::get('/producto/ajuste', [ProductController::class, 'settings'])->name('product.settings');
    Route::post('/producto/saveajuste', [ProductController::class, 'saveSettings'])->name('product.saveSettings');

    Route::get('/reporte-inventario', [ProductController::class, 'reporteValorInventario'])->name('inventario.reporte');
    Route::get('/products/search/{query}', [ProductController::class, 'search']);
