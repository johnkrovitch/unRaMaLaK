<?php

/**
 * BasePlanete
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $principal
 * @property string $taille
 * @property string $poids
 * @property string $atmosphere
 * @property string $climat
 * @property string $temperature
 * @property integer $id_user
 * @property Doctrine_Collection $Ville
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method integer             getPrincipal()   Returns the current record's "principal" value
 * @method string              getTaille()      Returns the current record's "taille" value
 * @method string              getPoids()       Returns the current record's "poids" value
 * @method string              getAtmosphere()  Returns the current record's "atmosphere" value
 * @method string              getClimat()      Returns the current record's "climat" value
 * @method string              getTemperature() Returns the current record's "temperature" value
 * @method integer             getIdUser()      Returns the current record's "id_user" value
 * @method Doctrine_Collection getVille()       Returns the current record's "Ville" collection
 * @method Planete             setId()          Sets the current record's "id" value
 * @method Planete             setName()        Sets the current record's "name" value
 * @method Planete             setPrincipal()   Sets the current record's "principal" value
 * @method Planete             setTaille()      Sets the current record's "taille" value
 * @method Planete             setPoids()       Sets the current record's "poids" value
 * @method Planete             setAtmosphere()  Sets the current record's "atmosphere" value
 * @method Planete             setClimat()      Sets the current record's "climat" value
 * @method Planete             setTemperature() Sets the current record's "temperature" value
 * @method Planete             setIdUser()      Sets the current record's "id_user" value
 * @method Planete             setVille()       Sets the current record's "Ville" collection
 * 
 * @package    unramalak
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePlanete extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('planete');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('principal', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('taille', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('poids', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('atmosphere', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('climat', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('temperature', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('id_user', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Ville', array(
             'local' => 'id',
             'foreign' => 'id_planete'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}