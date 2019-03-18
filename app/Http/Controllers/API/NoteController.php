<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

// Import model
use App\Note;
use Illuminate\Http\Request;

include "MyConstant.php";

class NoteController extends Controller
{

    /**
     * function Check token
     */
    // public function checkTokens(Request $request){
    //     $constant = new MyConstant();
    //     return $constant->checkTokenRight();
    // }

    /**
     *
     */

    public function createNewNote(Request $request)
    {

        try {
            // Get all variables inside request
            $title = $request->title;
            $desc = $request->desc;
            $creator = $request->creator;

            // Validate request
            $request->validate([
                'title' => 'required|string',
                'desc' => 'required|string',
            ]);

            // Collect data into a object
            $data = [
                'title' => $title,
                'desc' => $desc,
                'creator' => $creator,
            ];
            // Create a new object in Contract contain Data get from request
            $note = new Note($data);

            // Import object into database with record
            $note->save();

            // Return values to client
            return response()->json([
                'type' => 'NOTE',
                'status' => 'SUCCESS',
                'message' => 'Added new note!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'ADD',
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ], 400);
        }

    }

    public function getAllNote()
    {
        $notes = Note::all();

        return response()->json([
            'type' => 'NOTE',
            'status' => 'SUCCESS',
            'message' => 'Get all note ',
            'data' => $notes,
        ], 200);
    }

    public function deleteNote(Request $request)
    {
        try {
            $id = $request->id;
            Note::where('id', '=', $id)->limit(1)->delete();
            return response()->json([
                'type' => 'NOTE',
                'status' => 'SUCCESS',
                'message' => 'Deleted note',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'NOTE',
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ], 200);
        }
    }
    public function updateNote(Request $request)
    {
        try {
            $id = $request->id;
            $title = $request->title;
            $desc = $request->desc;

            $dataUpdate = [
                'title' => $title,
                'desc' => $desc,
            ];

            Note::where('id', '=', $id)->limit(1)->update(
                $dataUpdate
            );

            return response()->json([
                'type' => 'NOTE',
                'status' => 'SUCCESS',
                'message' => 'Updated note',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'type' => 'NOTE',
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ], 200);
        }
    }

}
