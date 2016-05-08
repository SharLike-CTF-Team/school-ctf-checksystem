<?php

namespace Map;

use \Team;
use \TeamQuery;
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
 * This class defines the structure of the 'team' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TeamTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TeamTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'jeopardy';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'team';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Team';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Team';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'team.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'team.name';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'team.email';

    /**
     * the column name for the logo_link field
     */
    const COL_LOGO_LINK = 'team.logo_link';

    /**
     * the column name for the city field
     */
    const COL_CITY = 'team.city';

    /**
     * the column name for the institution field
     */
    const COL_INSTITUTION = 'team.institution';

    /**
     * the column name for the info field
     */
    const COL_INFO = 'team.info';

    /**
     * the column name for the registr_date field
     */
    const COL_REGISTR_DATE = 'team.registr_date';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Email', 'LogoLink', 'City', 'Institution', 'Info', 'RegistrDate', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'email', 'logoLink', 'city', 'institution', 'info', 'registrDate', ),
        self::TYPE_COLNAME       => array(TeamTableMap::COL_ID, TeamTableMap::COL_NAME, TeamTableMap::COL_EMAIL, TeamTableMap::COL_LOGO_LINK, TeamTableMap::COL_CITY, TeamTableMap::COL_INSTITUTION, TeamTableMap::COL_INFO, TeamTableMap::COL_REGISTR_DATE, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'email', 'logo_link', 'city', 'institution', 'info', 'registr_date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Email' => 2, 'LogoLink' => 3, 'City' => 4, 'Institution' => 5, 'Info' => 6, 'RegistrDate' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'email' => 2, 'logoLink' => 3, 'city' => 4, 'institution' => 5, 'info' => 6, 'registrDate' => 7, ),
        self::TYPE_COLNAME       => array(TeamTableMap::COL_ID => 0, TeamTableMap::COL_NAME => 1, TeamTableMap::COL_EMAIL => 2, TeamTableMap::COL_LOGO_LINK => 3, TeamTableMap::COL_CITY => 4, TeamTableMap::COL_INSTITUTION => 5, TeamTableMap::COL_INFO => 6, TeamTableMap::COL_REGISTR_DATE => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'email' => 2, 'logo_link' => 3, 'city' => 4, 'institution' => 5, 'info' => 6, 'registr_date' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('team');
        $this->setPhpName('Team');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Team');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 64, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 64, null);
        $this->addColumn('logo_link', 'LogoLink', 'VARCHAR', true, 64, null);
        $this->addColumn('city', 'City', 'VARCHAR', true, 40, null);
        $this->addColumn('institution', 'Institution', 'VARCHAR', true, 64, null);
        $this->addColumn('info', 'Info', 'LONGVARCHAR', true, null, null);
        $this->addColumn('registr_date', 'RegistrDate', 'TIMESTAMP', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('statistic', '\\Statistic', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':team_id',
    1 => ':id',
  ),
), null, null, 'statistics', false);
        $this->addRelation('Participants', '\\Participants', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':team_id',
    1 => ':id',
  ),
), null, null, 'Participantss', false);
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
        return $withPrefix ? TeamTableMap::CLASS_DEFAULT : TeamTableMap::OM_CLASS;
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
     * @return array           (Team object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TeamTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TeamTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TeamTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TeamTableMap::OM_CLASS;
            /** @var Team $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TeamTableMap::addInstanceToPool($obj, $key);
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
            $key = TeamTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TeamTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Team $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TeamTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TeamTableMap::COL_ID);
            $criteria->addSelectColumn(TeamTableMap::COL_NAME);
            $criteria->addSelectColumn(TeamTableMap::COL_EMAIL);
            $criteria->addSelectColumn(TeamTableMap::COL_LOGO_LINK);
            $criteria->addSelectColumn(TeamTableMap::COL_CITY);
            $criteria->addSelectColumn(TeamTableMap::COL_INSTITUTION);
            $criteria->addSelectColumn(TeamTableMap::COL_INFO);
            $criteria->addSelectColumn(TeamTableMap::COL_REGISTR_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.logo_link');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.institution');
            $criteria->addSelectColumn($alias . '.info');
            $criteria->addSelectColumn($alias . '.registr_date');
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
        return Propel::getServiceContainer()->getDatabaseMap(TeamTableMap::DATABASE_NAME)->getTable(TeamTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TeamTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TeamTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TeamTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Team or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Team object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Team) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TeamTableMap::DATABASE_NAME);
            $criteria->add(TeamTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TeamQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TeamTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TeamTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the team table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TeamQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Team or Criteria object.
     *
     * @param mixed               $criteria Criteria or Team object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Team object
        }

        if ($criteria->containsKey(TeamTableMap::COL_ID) && $criteria->keyContainsValue(TeamTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TeamTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TeamQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TeamTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TeamTableMap::buildTableMap();
