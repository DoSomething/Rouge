<?php

namespace Rogue\Http\Controllers\Three;

use Rogue\Models\Signup;
use Illuminate\Http\Request;
use Rogue\Http\Controllers\Api\ApiController;
use Rogue\Http\Transformers\Three\SignupTransformer;

class SignupsController extends ApiController
{
    /**
     * @var \League\Fractal\TransformerAbstract;
     */
    protected $transformer;

    /**
     * Create a controller instance.
     *
     * @param  PostContract  $posts
     * @return void
     */
    public function __construct()
    {
        $this->transformer = new SignupTransformer;
    }

    /**
     * Returns signups.
     * GET /signups
     *
     * @param Request $request
     * @return ]Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $this->newQuery(Signup::class);

        return $this->paginatedCollection($query, $request);
    }

    /**
     * Returns a specific signup.
     * GET /signups/:id
     *
     * @param Request $request
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $signup = Signup::findOrFail($id);

        return $this->item($signup, 200, [], $this->transformer, $request->query('include'));
    }

    /**
     * Delete a signup.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $signupDeleted = Signup::findOrFail($id)->delete();

        if ($signupDeleted) {
            return response()->json(['code' => 200, 'message' => 'Signup deleted.']);
        } else {
            return response()->json(['code' => 500, 'message' => 'There was an error deleting the signup']);
        }
    }
}
