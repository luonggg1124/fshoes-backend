<?php

namespace App\Services\Post;

use Mockery\Exception;

use App\Http\Resources\PostResource;
use App\Http\Traits\Paginate;
use Illuminate\Database\QueryException;
use App\Repositories\Post\PostRepositoryInterface;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostService implements PostServiceInterface
{
    use  Paginate;
    public function __construct(protected PostRepositoryInterface $postRepository)
    {
    }


    function getAll(array $params)
    {
        $trashed = request()->query('trashed');
        $paginate = request()->query('paginate');
        $per_page = request()->query('per_page');
        if($paginate){
            $posts = $this->postRepository->query()->when(!$trashed,function($q){
                $q->withTrashed();
            })->paginate($per_page ?? 10);
            return [
                'paginator' => $this->paginate($posts),
                'data' => PostResource::collection(
                    $posts->items()
                ),
            ];
        }else {
            $posts = $this->postRepository->query()->when(!$trashed,function($q){
                $q->withTrashed();
            })->get();
            return response()->json(PostResource::collection($posts), 200);
        }
        
    }

    function findById(int|string $id)
    {
        try{
            $post = $this->postRepository->query()->findOrFail($id);
            $post->views++;
            $post->save();
            return response()->json(PostResource::make($post), 200);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => __('messages.error-not-found')], 404);
        }
    }

    function findBySlug(int|string $slug)
    {
        try{
            $post = $this->postRepository->query()->where('slug' , $slug)->first();
            $post->views++;
            $post->save();
            return response()->json(PostResource::make($post), 200);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => __('messages.error-not-found')], 404);
        }
    }
    function findByUserId(int|string $id)
    {
        try{
            $post = $this->postRepository->query()->where('author_id', $id)->get();
            return response()->json(PostResource::make($post), 200);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => __('messages.error-not-found')], 404);
        }
    }

    function create(array $data, array $option = [])
    {
        try {
            $post = $this->postRepository->create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'topic_id' => $data['topic_id'],
                'author_id' => $data['author_id'],
                "theme"=>$data['theme'],
                "public_id" => $data['public_id']
            ]);

            return PostResource::make($post);
        } catch (QueryException $exception) {
            logger()->error($exception->getMessage(),[
                'line' => $exception->getLine(),
                'message' => $exception->getTrace()
            ]);
            if ($exception->getCode() === '23000') {
                return response()->json(['message' => __('messages.post.error-already-exists')], 422);
            }
            return response()->json(['message' => __('messages.error-internal-server')], 500);
        } catch (Exception $exception) {
            // Handle general exceptions
            return response()->json(__('messages.error-internal-server'), 500);
        }

    }

    function update(int|string $id, array $data, array $option = [])
    {
        try {
            $post = $this->postRepository->find($id);
            if($post) $post->update($data);
            else throw new ModelNotFoundException(__('messages.post.error-Could-not-found-post'));
            return PostResource::make($post);
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
                return response()->json(['message' => __('messages.post.error-already-exists')], 422);
            }
            return response()->json(['message' => __('messages.error-internal-server')], 500);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => __('messages.error-not-found')], 404);
        }
    }

    function delete(int|string $id)
    {
        try {
            $post = $this->postRepository->query()->find($id);
            if ($post) {
                $post->delete();
                return response()->json(['message' => __('messages.delete-success')], 200);
            } else {
                throw new ModelNotFoundException(__('messages.post.error-Could-not-found-post'));
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['error' => __('messages.post.error-delete-post')], 500);
        }
    }

    function restore(int|string $id)
    {
        try {
            $post = $this->postRepository->query()->withTrashed()->find($id);
            if ($post) {
                $post->restore();
                return response()->json(['message' => __('messages.created-success')], 200);
            } else {
                throw new ModelNotFoundException(__('messages.post.error-Could-not-found-post'));
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['error' => __('messages.post.error-restoring-post')], 500);
        }
    }

    function forceDelete(int|string $id)
    {
        try {
            $post = $this->postRepository->query()->withTrashed()->where('id', $id)->first();
            if ($post) {
                $post->forceDelete();
                return response()->json(['message' => __('messages.delete-success')], 200);
            } else {
                return response()->json(["message"=> __('messages.error-not-found')] , 500);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['error' => __('messages.post.error-delete-post')], 500);
        }
    }

}
