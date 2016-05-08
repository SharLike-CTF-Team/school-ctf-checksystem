<?php

namespace Map;

use \Participants;
use \ParticipantsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'participants' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ParticipantsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ParticipantsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'jeopardy';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'participants';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Participants';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Participants';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'participants.id';

    /**
     * the column name for the team_id field
     */
    const COL_TEAM_ID = 'participants.team_id';

    /**
     * the column name for the pass field
     */
    const COL_PASS = 'participants.pass';

    /**
     * the column name for the secretkey field
     */
    const COL_SECRETKEY = 'participants.secretkey';

    /**
     * the column name for the id_pass field
     */
    const COL_ID_PASS = 'participants.id_pass';

    /**
     * the column name for the ip field
     */
    const COL_IP = 'participants.ip';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Team_id', 'Pass', 'Secretkey', 'Id_pass', 'Ip', ),
        self::TYPE_CAMELNAME     => array('id', 'team_id', 'pass', 'secretkey', 'id_pass', 'ip', ),
        self::TYPE_COLNAME       => array(ParticipantsTableMap::COL_ID, ParticipantsTableMap::COL_TEAM_ID, ParticipantsTableMap::COL_PASS, ParticipantsTableMap::COL_SECRETKEY, ParticipantsTableMap::COL_ID_PASS, ParticipantsTableMap::COL_IP, ),
        self::TYPE_FIELDNAME     => array('id', 'team_id', 'pass', 'secretkey', 'id_pass', 'ip', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Team_id' => 1, 'Pass' => 2, 'Secretkey' => 3, 'Id_pass' => 4, 'Ip' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'team_id' => 1, 'pass' => 2, 'secretkey' => 3, 'id_pass' => 4, 'ip' => 5, ),
        self::TYPE_COLNAME       => array(ParticipantsTableMap::COL_ID => 0, ParticipantsTableMap::COL_TEAM_ID => 1, ParticipantsTableMap::COL_PASS => 2, ParticipantsTableMap::COL_SECRETKEY => 3, ParticipantsTableMap::COL_ID_PASS => 4, ParticipantsTableMap::COL_IP => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'team_id' => 1, 'pass' => 2, 'secretkey' => 3, 'id_pass' => 4, 'ip' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('participants');
        $this->setPhpName('Participants');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Participants');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('team_id', 'Team_id', 'INTEGER', 'team', 'id', true, null, null);
        $this->addColumn('pass', 'Pass', 'VARCHAR', true, 40, null);
        $this->addColumn('secretkey', 'Secretkey', 'VARCHAR', true, 8, null);
        $this->addColumn('id_pass', 'Id_pass', 'VARCHAR', true, 3, null);
        $this->addColumn('ip', 'Ip', 'VARCHAR', false, 15, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Team', '\\Team', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':team_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ParticipantsTableMap::CLASS_DEFAULT : ParticipantsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Participants object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ParticipantsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ParticipantsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ParticipantsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ParticipantsTableMap::OM_CLASS;
            /** @var Participants $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ParticipantsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ParticipantsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ParticipantsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Participants $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ParticipantsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ParticipantsTableMap::COL_ID);
            $criteria->addSelectColumn(ParticipantsTableMap::COL_TEAM_ID);
            $criteria->addSelectColumn(ParticipantsTableMap::COL_PASS);
            $criteria->addSelectColumn(ParticipantsTableMap::COL_SECRETKEY);
            $criteria->addSelectColumn(ParticipantsTableMap::COL_ID_PASS);
            $criteria->addSelectColumn(ParticipantsTableMap::COL_IP);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.team_id');
            $criteria->addSelectColumn($alias . '.pass');
            $criteria->addSelectColumn($alias . '.secretkey');
            $criteria->addSelectColumn($alias . '.id_pass');
            $criteria->addSelectColumn($alias . '.ip');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ParticipantsTableMap::DATABASE_NAME)->getTable(ParticipantsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ParticipantsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ParticipantsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ParticipantsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Participants or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Participants object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Participants) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ParticipantsTableMap::DATABASE_NAME);
            $criteria->add(ParticipantsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ParticipantsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ParticipantsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ParticipantsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the participants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ParticipantsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Participants or Criteria object.
     *
     * @param mixed               $criteria Criteria or Participants object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Participants object
        }

        if ($criteria->containsKey(ParticipantsTableMap::COL_ID) && $criteria->keyContainsValue(ParticipantsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ParticipantsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ParticipantsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ParticipantsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ParticipantsTableMap::buildTableMap();
