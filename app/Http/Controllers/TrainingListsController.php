<?php

namespace App\Http\Controllers;

use App\Models\TrainingLists;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainingListsController extends Controller
{
    public function index()
    {
        $trainingLists = TrainingLists::orderBy('id', 'desc')->paginate(20);

        return Inertia::render('AttendeesPage/TrainingLists/TrainingLists', [
            'trainingLists' => $trainingLists
        ]);
    }

    public function create(Request $request)
    {
        TrainingLists::create($request->validate([
            'training_name' => ['required']
        ]));

        return to_route('attendees.trainingLists.index');
    }

    public function edit(TrainingLists $trainingLists)
    {
        return Inertia::render('AttendeesPage/TrainingLists/TrainingListsEdit', ['trainingLists' => $trainingLists]);
    }

    public function update(TrainingLists $trainingLists, Request $request)
    {
        $trainingLists->update($request->validate([
            'training_name' => ['required']
        ]));

        return to_route('attendees.trainingLists.index');
    }

    public function view(TrainingLists $trainingLists)
    {
        return Inertia::render('AttendeesPage/TrainingLists/TrainingListsView', ['trainingLists' => $trainingLists]);
    }

    public function delete(TrainingLists $trainingLists)
    {
        $trainingLists->delete();
    }
}
