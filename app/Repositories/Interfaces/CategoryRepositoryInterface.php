<?php

namespace App\Repositories\Interfaces;

Interface CategoryRepositoryInterface{
    public function all();
    public function store($request);
    public function destroy($category);
    public function update($request, $category);
}