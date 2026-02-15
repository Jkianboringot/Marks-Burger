<div>

    <div class="card">

        <div class="card-body table-responsive">
            <div class="card-body table-responsive">

                <table class="table table-hover" style="table-layout: fixed;">
                    <thead class="thead-inverse">





                        <tr class="text-center">

                            <th>ingredient</th>
                            <!-- <th>threshold</th>
                            <th>Category</th>

                            <th>Stock</th> -->

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($addToProducts as $addToProduct)
                        <tr class="text-center">


                            <td>
                                @foreach ($addToProduct->ingredients as $ingredient)
                                
                                {{ $ingredient->name }}
                                @endforeach

                            </td>





                        </tr>
                        @endforeach
                     


                    </tbody>
                </table>

              
            </div>
        </div>
    </div>
</div>