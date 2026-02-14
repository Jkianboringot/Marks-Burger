<div>

    <div class="card">

        <div class="card-body table-responsive">
            <div class="card-body table-responsive">

                <table class="table table-hover" style="table-layout: fixed;">
                    <thead class="thead-inverse">





                        <tr class="text-center">

                            <th>Ingredient</th>
                            <th>threshold</th>
                            <th>Category</th>

                            <th>Stock</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($ingredients as $ingredient)
                        <tr class="text-center">


                            <td>
                                {{ $ingredient->name }}
                            </td>
                            <td>{{ number_format($ingredient->threshold) }}</td>


                            <td>{{ $ingredient->category_id }}</td>


                            <td>
                               {{ number_format($ingredient->ingredient_stock) }}

                            </td>

                        </tr>
                        @endforeach
                     


                    </tbody>
                </table>

              
            </div>
        </div>
    </div>
</div>