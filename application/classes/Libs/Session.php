<?PHP

/**
 * ding
 * public function set($key,$array = NULL)
 * $key=>session_id
 * $array = array(
    'user_id' => 'user_id',
    'token'    => 'token',
    'expire_in'   => 'expire_in'
 * );
 **/
class Libs_Session{
    // Database table name
    protected $_table = 'session_app';
    // Database column names
    protected $_columns = array(
        'session_id'  => 'session_id',
        'user_id' => 'user_id',
        'token'    => 'token',
        'expire_in'   => 'expire_in',
        'name'=>'name',
        'mobile'=>'mobile',
        'identity_code'=>'identity_code',
        'credit_auth'=>'credit_auth'
    );
    // Garbage collection requests
    protected $_gc = 500;

    // The current session id
    protected $_session_id;

    // The old session id
    protected $_update_id;
    protected $_config;

    public function __construct()
    {
        $this->_config = Kohana::$config->load('session.session_app');
        $this->_table = $this->_config['table'];
        $this->_columns = $this->_config['columns'];

    }

    public function set($key,$array = NULL)
    {
        if(!Valid::not_empty($key)){
            return NULL;
        }
        if(!Valid::not_empty($array)){
            return NULL;
        }
        if(!isset($array['user_id'])&&empty($array['user_id'])&&!isset($array['token'])&&empty($array['token'])&&!isset($array['expire_in'])&&empty($array['expire_in'])&&empty($array['credit_auth'])){
            return NULL;
        }
        $session_id = Cookie::get($key);
        if(Valid::not_empty($session_id)){
            $result = DB::select(implode(',',$this->_columns))
                ->from($this->_table)
                ->where('session_id',"=",$session_id)
                ->order_by('update_time','DESC')
                ->limit(1)
                ->execute();
            if($result->count())
            {
                // Update the row
                if(isset($result->current()['expire_in'])&&$result->current()['expire_in']<time())
                {
                    $session_id = uniqid(Text::random('numeric',8));
                    $query = DB::insert($this->_table, $this->_columns)
                        ->values(array(':session_id', ':user_id', ':token', ':expire_in',':name',':mobile',':identity_code',':credit_auth'));
                }else
                {
                    $query = DB::update($this->_table)
                        ->value($this->_columns['user_id'], ':user_id')
                        ->value($this->_columns['token'], ':token')
                        ->value($this->_columns['expire_in'], ':expire_in')
                        ->value($this->_columns['name'], ':name')
                        ->value($this->_columns['mobile'], ':mobile')
                        ->value($this->_columns['identity_code'], ':identity_code')
                        ->value($this->_columns['credit_auth'], ':credit_auth')
                        ->where($this->_columns['session_id'], '=', ':session_id');
                }
            }else
            {
                $session_id = uniqid(Text::random('numeric',8));
                $query = DB::insert($this->_table, $this->_columns)
                    ->values(array(':session_id', ':user_id', ':token', ':expire_in',':name',':mobile',':identity_code',':credit_auth'));
            }
        }else{
            $session_id = uniqid(Text::random('numeric',8));
            $query = DB::insert($this->_table, $this->_columns)
                ->values(array(':session_id', ':user_id', ':token', ':expire_in',':name',':mobile',':identity_code',':credit_auth'));
        }
        $query
            ->param(':user_id',  $array['user_id'])
            ->param(':token',   $array['token'])
            ->param(':expire_in',   time()+$array['expire_in'])
            ->param(':session_id', $session_id)
            ->param(':name', $array['name'])
            ->param(':mobile', $array['mobile'])
            ->param(':credit_auth', $array['credit_auth'])
            ->param(':identity_code', $array['identity_code']);
        if($query->execute()){
            Cookie::set($key,$session_id,$array['expire_in']);
            return TRUE;
        }else{
            return NULL;
        }
    }

    public function get($key)
    {
        if ($id = Cookie::get($key))
        {
            $result = DB::select(implode(',',$this->_columns))
                ->from($this->_table)
                ->where($key, '=', ':id')
                ->where('expire_in', '>', ':expire_in')
                ->order_by('update_time','DESC')
                ->limit(1)
                ->param(':id', $id)
                ->param(':expire_in', time())
                ->execute();
            if ($result->count())
            {
                return $result->current();
            }
        }
        return NULL;
    }

    public function sessionDelete($key)
    {
        if ($id = Cookie::get($key))
        {
            // Delete the current session
            $query = DB::delete($this->_table)
                ->where($this->_columns['session_id'], '=', ':id')
                ->param(':id', $id);
            try
            {
                // Execute the query
                $query->execute();
                // Delete the cookie
                Cookie::delete($key);
            }
            catch (Exception $e)
            {
                // An error occurred, the session has not been deleted
                return FALSE;
            }
            return TRUE;
        }
    }

    public function id()
    {
        return $this->_session_id;
    }




    protected function _read($id = NULL)
    {
        if ($id OR $id = Cookie::get($this->_name))
        {
            $result = DB::select(array($this->_columns['contents'], 'contents'))
                ->from($this->_table)
                ->where($this->_columns['session_id'], '=', ':id')
                ->limit(1)
                ->param(':id', $id)
                ->execute($this->_db);
            if ($result->count())
            {
                // Set the current session id
                $this->_session_id = $this->_update_id = $id;

                // Return the contents
                return $result->get('contents');
            }
        }

        // Create a new session id
        $this->_regenerate();

        return NULL;
    }

    protected function _regenerate()
    {
        // Create the query to find an ID
        $query = DB::select($this->_columns['session_id'])
            ->from($this->_table)
            ->where($this->_columns['session_id'], '=', ':id')
            ->limit(1)
            ->bind(':id', $id);

        do
        {
            // Create a new session id
            $id = str_replace('.', '-', uniqid(NULL, TRUE));

            // Get the the id from the database
            $result = $query->execute($this->_db);
        }
        while ($result->count());

        return $this->_session_id = $id;
    }

    protected function _write()
    {
        if ($this->_update_id === NULL)
        {
            // Insert a new row
            $query = DB::insert($this->_table, $this->_columns)
                ->values(array(':new_id', ':active', ':contents'));
        }
        else
        {
            // Update the row
            $query = DB::update($this->_table)
                ->value($this->_columns['last_active'], ':active')
                ->value($this->_columns['contents'], ':contents')
                ->where($this->_columns['session_id'], '=', ':old_id');

            if ($this->_update_id !== $this->_session_id)
            {
                // Also update the session id
                $query->value($this->_columns['session_id'], ':new_id');
            }
        }

        $query
            ->param(':new_id',   $this->_session_id)
            ->param(':old_id',   $this->_update_id)
            ->param(':active',   $this->_data['last_active'])
            ->param(':contents', $this->__toString());

        // Execute the query
        $query->execute($this->_db);

        // The update and the session id are now the same
        $this->_update_id = $this->_session_id;

        // Update the cookie with the new session id
        Cookie::set($this->_name, $this->_session_id, $this->_lifetime);

        return TRUE;
    }

    /**
     * @return  bool
     */
    protected function _restart()
    {
        $this->_regenerate();

        return TRUE;
    }

    protected function _destroy()
    {
        if ($this->_update_id === NULL)
        {
            // Session has not been created yet
            return TRUE;
        }

        // Delete the current session
        $query = DB::delete($this->_table)
            ->where($this->_columns['session_id'], '=', ':id')
            ->param(':id', $this->_update_id);

        try
        {
            // Execute the query
            $query->execute($this->_db);

            // Delete the old session id
            $this->_update_id = NULL;

            // Delete the cookie
            Cookie::delete($this->_name);
        }
        catch (Exception $e)
        {
            // An error occurred, the session has not been deleted
            return FALSE;
        }

        return TRUE;
    }

    protected function _gc()
    {
        if ($this->_lifetime)
        {
            // Expire sessions when their lifetime is up
            $expires = $this->_lifetime;
        }
        else
        {
            // Expire sessions after one month
            $expires = Date::MONTH;
        }

        // Delete all sessions that have expired
        DB::delete($this->_table)
            ->where($this->_columns['last_active'], '<', ':time')
            ->param(':time', time() - $expires)
            ->execute($this->_db);
    }



}
