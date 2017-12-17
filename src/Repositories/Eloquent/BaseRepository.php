<?php
namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Contract\RestfulInterface;

abstract class BaseRepository implements RestfulInterface{

  protected $model;

  public function __construct()
  {
    $this->model = $this->setModel();
  }

  abstract public function getModel();

  public function setModel()
  {
    return $this->model = app()->make($this->getModel() );
  }

  /*
  ** MAKE Eager Loading
  */
  public function make(array $with = [])
  {
      return $this->model->with($with);
  }

  /*GET QUERY BUILDER*/
  public function query($columns = ['*'], $with = [])
  {
      $query = $this->make($with);
      return $query->select($columns);
  }
  /**
 	 * GET ALL
 	 *
 	 * @param type
 	 * @return void
	 */
  public function all($columns = array('*'), $with = [])
  {
    $query = $this->make($with);
    return $query->get($columns);

  }

  /**
 	 * PAGINATION
 	 *
 	 * @param type
 	 * @return void
	 */
  public function paginate($limit = null, $columns = array('*'))
  {
    return $this->model->paginate($limit, $columns);
  }

    /**
 	 * FIND ID
 	 *
 	 * @param type
 	 * @return void
	 */
  public function find($id, $columns = array('*'), $with = [])
  {
    try {
      $query = $this->make($with);
      return $query->findOrFail($id, $columns);
    } catch (ModelNotFoundException  $e) {
      return false;
    }
  }

  /**
	 * WHERE FOLLOW FIELD
	 *
	 * @param type
	 * @return void
 */
  public function findByField($field, $value, $columns = array('*'))
  {
    return $this->model->where($field,'=',$value)->select($columns);
  }
/**
	 * WHERE IN
	 *
	 * @param type
	 * @return void
 */

public function findWhereIn( $field, array $values, $columns = array('*'))
{
    return $this->model->whereIn($field, $values)->get($columns);
}

/**
 * WHERE NOT IN
 *
 * @param type
 * @return void
*/

 public function findWhereNotIn( $field, array $values, $columns = array('*'), $with = [])
 {
     $query = $this->make($with);
     return $query->whereNotIn($field, $values)->get($columns);
 }

 /**
	 * CREATE
	 *
	 * @param type
	 * @return void
 */
  public function create(array $attributes)
  {
      return $this->model->create($attributes);
  }

  /**
	 * UPDATE
	 *
	 * @param type
	 * @return void
 */
 public function update(array $attributes, $id)
 {
     try {
        $result =  $this->model->findOrFail($id);
        $result->update($attributes);
        return $result;
    } catch (ModelNotFoundException $e) {
        return false;
    }
 }

 /**
	 * DELETE
	 *
	 * @param type
	 * @return void
 */
	public function delete($id)
    {
        try {
            $result = $this->model->findOrFail($id);
            $result->destroy($id);
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
	 * DELETE ALL
	 *
	 * @param type
	 * @return void
 */
 public function deleteAll($Arr_data)
 {
     $this->model->destroy($Arr_data);
     return true;
 }

 /**
 * GET ORDER
 **/
public function getOrder()
{
  try {
    $inst = $this->model->orderBy('id','DESC')->firstOrFail();
    return $inst->order + 1;
  } catch (ModelNotFoundException $e) {
    return 1;
  }


}

}
