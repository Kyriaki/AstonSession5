<?php
/**
 * Created by iKNSA.
 * Author: Khalid Sookia <khalidsookia@gmail.com>
 * Date: 05/12/16
 * Time: 20:12
 */

namespace Assur\Entity;

use Romenys\Framework\Components\Model;

class Assur extends Model
{
    private $id;

    private $name = '';


    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return Car
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}