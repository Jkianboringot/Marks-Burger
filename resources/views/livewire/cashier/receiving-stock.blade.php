<div>

    <div class="card">

        <div class="card-body table-responsive">
            <div class="card-body table-responsive">

                <table class="table table-hover" style="width:100%">
                    <thead class="thead-inverse">
                        <tr class="text-center">
                            <th>date</th>

                            <th>ingredient</th>
                            <th>quantity</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addToProducts as $addToProduct)
                        <tr class="text-center" style="padding: 3rem;">
                            <td>{{ $addToProduct->created_at }}</td>
                            <td>
                                @foreach ($addToProduct->ingredients as $ingredient)
                                {{ $ingredient->name }}
                                @endforeach
                            </td>
                            <td>
                               @foreach ($addToProduct->ingredients as $ingredient)
                                {{ $ingredient->pivot->quantity }}
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