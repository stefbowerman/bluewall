<?php

/**
* Instagram PHP
* @author Galen Grover <galenjr@gmail.com>
* @license http://opensource.org/licenses/mit-license.php The MIT License
*/

namespace Instagram;

use \Instagram\User;

/**
 * Comment class
 *
 * @see \Instagram\CurrentUser::addMediaComment()
 * @see \Instagram\CurrentUser::deleteMediaComment()
 * @see \Instagram\Media::getCaption()
 * @see \Instagram\Media::getComments()
 */
class Comment extends \Instagram\Core\BaseObjectAbstract {

    /**
     * Cached user
     * 
     * @var \Instagram\User
     */
    protected $user = null;

    /**
     * Get comment creation time
     *
     * @param $format Time format {@link http://php.net/manual/en/function.date.php}
     * @return string Returns the creation time with optional formatting
     * @access public
     */
    public function getCreatedTime( $format = null ) {
        if ( $format ) {
            $date = date( $format, $this->data->created_time );
        }
        else {
            $date = $this->data->created_time;
        }
        return $date;
    }

    /**
     * Get the created time ago
     *
     * @return string
     * @access public
     */
    public function getCreatedTimeAgo() {
        $timeStamp = $this->getCreatedTime('U');
        $elapsed = time() - $timeStamp;
        
        if ($elapsed < 1)
            return 'just now';

        $lengths = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                          30 * 24 * 60 * 60       =>  'month',
                          24 * 60 * 60            =>  'day',
                          60 * 60                 =>  'hour',
                          60                      =>  'minute',
                          1                       =>  'second');

        foreach ($lengths as $secs => $str)
        {
            $d = $elapsed / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }

    /**
     * Get the comment text
     *
     * @access public
     * @return string
     */
    public function getText() {
        return $this->data->text;
    }

    /**
     * Get the comment's user
     *
     * @access public
     * @return \Instagram\User
     */
    public function getUser() {
        if ( !$this->user ) {
            $this->user = new User( $this->data->from, $this->proxy );
        }
        return $this->user;
    }

    /**
     * Magic toString method
     *
     * Return the comment text
     *
     * @access public
     * @return string
     */
    public function __toString() {
        return $this->getText();
    }

}