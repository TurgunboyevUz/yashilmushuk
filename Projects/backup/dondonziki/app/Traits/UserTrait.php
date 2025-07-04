<?php

namespace App\Traits;

use App\Helpers\UserHelper;

trait UserTrait
{
    public function set($id)
    {
        UserHelper::set($id);

        return $this;
    }

    public function user()
    {
        return UserHelper::user();
    }

    public function save($name, $value)
    {
        return UserHelper::save($name, $value);
    }

    public function get($name)
    {
        return UserHelper::get($name);
    }

    public function has($name)
    {
        return UserHelper::has($name);
    }

    public function delete($name)
    {
        return UserHelper::delete($name);
    }

    public function win($id)
    {
        $this->set($id)->user()->increment('win');
    }

    public function draw($id)
    {
        $this->set($id)->user()->increment('draw');
    }

    public function lose($id)
    {
        $this->set($id)->user()->increment('lose');
    }

    public function inlineWin($id)
    {
        $this->set($id)->user()->increment('inline_win');
    }

    public function inlineDraw($id)
    {
        $this->set($id)->user()->increment('inline_draw');
    }

    public function inlineLose($id)
    {
        $this->set($id)->user()->increment('inline_lose');
    }

    public function update($name, $value)
    {
        return $this->user()->update([$name => $value]);
    }
}

?>