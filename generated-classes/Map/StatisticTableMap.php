<?php

namespace Map;

use \Statistic;
use \StatisticQuery;
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
 * This class defines the structure of the 'statistic' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StatisticTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.StatisticTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'jeopardy';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'statistic';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Statistic';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Statistic';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'statistic.id';

    /**
     * the column name for the team_id field
     */
    const COL_TEAM_ID = 'statistic.team_id';

    /**
     * the column name for the task_id field
     */
    const COL_TASK_ID = 'statistic.task_id';

    /**
     * the column name for the flag_done field
     */
    const COL_FLAG_DONE = 'statistic.flag_done';

    /**
     * the column name for the time_done field
     */
    const COL_TIME_DONE = 'statistic.time_done';

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
        self::TYPE_PHPNAME       => array('Id', 'TeamId', 'TaskId', 'FlagDone', 'TimeDone', ),
        self::TYPE_CAMELNAME     => array('id', 'teamId', 'taskId', 'flagDone', 'timeDone', ),
        self::TYPE_COLNAME       => array(StatisticTableMap::COL_ID, StatisticTableMap::COL_TEAM_ID, StatisticTableMap::COL_TASK_ID, StatisticTableMap::COL_FLAG_DONE, StatisticTableMap::COL_TIME_DONE, ),
        self::TYPE_FIELDNAME     => array('id', 'team_id', 'task_id', 'flag_done', 'time_done', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'TeamId' => 1, 'TaskId' => 2, 'FlagDone' => 3, 'TimeDone' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'teamId' => 1, 'taskId' => 2, 'flagDone' => 3, 'timeDone' => 4, ),
        self::TYPE_COLNAME       => array(StatisticTableMap::COL_ID => 0, StatisticTableMap::COL_TEAM_ID => 1, StatisticTableMap::COL_TASK_ID => 2, StatisticTableMap::COL_FLAG_DONE => 3, StatisticTableMap::COL_TIME_DONE => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'team_id' => 1, 'task_id' => 2, 'flag_done' => 3, 'time_done' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('statistic');
        $this->setPhpName('Statistic');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Statistic');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 5, null);
        $this->addForeignKey('team_id', 'TeamId', 'INTEGER', 'team', 'id', true, 5, null);
        $this->addForeignKey('task_id', 'TaskId', 'INTEGER', 'task', 'id', true, 5, null);
        $this->addColumn('flag_done', 'FlagDone', 'BOOLEAN', true, 1, null);
        $this->addColumn('time_done', 'TimeDone', 'TIME', true, null, null);
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
        $this->addRelation('Task', '\\Task', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':task_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Attempt', '\\Attempt', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':statistic_id',
    1 => ':id',
  ),
), null, null, 'Attempts', false);
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
        return $withPrefix ? StatisticTableMap::CLASS_DEFAULT : StatisticTableMap::OM_CLASS;
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
     * @return array           (Statistic object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StatisticTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StatisticTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StatisticTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StatisticTableMap::OM_CLASS;
            /** @var Statistic $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StatisticTableMap::addInstanceToPool($obj, $key);
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
            $key = StatisticTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StatisticTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Statistic $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StatisticTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(StatisticTableMap::COL_ID);
            $criteria->addSelectColumn(StatisticTableMap::COL_TEAM_ID);
            $criteria->addSelectColumn(StatisticTableMap::COL_TASK_ID);
            $criteria->addSelectColumn(StatisticTableMap::COL_FLAG_DONE);
            $criteria->addSelectColumn(StatisticTableMap::COL_TIME_DONE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.team_id');
            $criteria->addSelectColumn($alias . '.task_id');
            $criteria->addSelectColumn($alias . '.flag_done');
            $criteria->addSelectColumn($alias . '.time_done');
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
        return Propel::getServiceContainer()->getDatabaseMap(StatisticTableMap::DATABASE_NAME)->getTable(StatisticTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(StatisticTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(StatisticTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new StatisticTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Statistic or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Statistic object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StatisticTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Statistic) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StatisticTableMap::DATABASE_NAME);
            $criteria->add(StatisticTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = StatisticQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StatisticTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StatisticTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the statistic table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StatisticQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Statistic or Criteria object.
     *
     * @param mixed               $criteria Criteria or Statistic object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StatisticTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Statistic object
        }

        if ($criteria->containsKey(StatisticTableMap::COL_ID) && $criteria->keyContainsValue(StatisticTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StatisticTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = StatisticQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // StatisticTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StatisticTableMap::buildTableMap();
