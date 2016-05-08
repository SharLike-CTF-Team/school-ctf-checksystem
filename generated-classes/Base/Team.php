<?php

namespace Base;

use \Participants as ChildParticipants;
use \ParticipantsQuery as ChildParticipantsQuery;
use \Statistic as ChildStatistic;
use \StatisticQuery as ChildStatisticQuery;
use \Team as ChildTeam;
use \TeamQuery as ChildTeamQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\TeamTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'team' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Team implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TeamTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the logo_link field.
     *
     * @var        string
     */
    protected $logo_link;

    /**
     * The value for the city field.
     *
     * @var        string
     */
    protected $city;

    /**
     * The value for the institution field.
     *
     * @var        string
     */
    protected $institution;

    /**
     * The value for the info field.
     *
     * @var        string
     */
    protected $info;

    /**
     * The value for the registr_date field.
     *
     * @var        \DateTime
     */
    protected $registr_date;

    /**
     * @var        ObjectCollection|ChildStatistic[] Collection to store aggregation of ChildStatistic objects.
     */
    protected $collstatistics;
    protected $collstatisticsPartial;

    /**
     * @var        ObjectCollection|ChildParticipants[] Collection to store aggregation of ChildParticipants objects.
     */
    protected $collParticipantss;
    protected $collParticipantssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStatistic[]
     */
    protected $statisticsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParticipants[]
     */
    protected $participantssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Team object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Team</code> instance.  If
     * <code>obj</code> is an instance of <code>Team</code>, delegates to
     * <code>equals(Team)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Team The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [logo_link] column value.
     *
     * @return string
     */
    public function getLogoLink()
    {
        return $this->logo_link;
    }

    /**
     * Get the [city] column value.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the [institution] column value.
     *
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Get the [info] column value.
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Get the [optionally formatted] temporal [registr_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegistrDate($format = NULL)
    {
        if ($format === null) {
            return $this->registr_date;
        } else {
            return $this->registr_date instanceof \DateTime ? $this->registr_date->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TeamTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[TeamTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[TeamTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [logo_link] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setLogoLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->logo_link !== $v) {
            $this->logo_link = $v;
            $this->modifiedColumns[TeamTableMap::COL_LOGO_LINK] = true;
        }

        return $this;
    } // setLogoLink()

    /**
     * Set the value of [city] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->city !== $v) {
            $this->city = $v;
            $this->modifiedColumns[TeamTableMap::COL_CITY] = true;
        }

        return $this;
    } // setCity()

    /**
     * Set the value of [institution] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setInstitution($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->institution !== $v) {
            $this->institution = $v;
            $this->modifiedColumns[TeamTableMap::COL_INSTITUTION] = true;
        }

        return $this;
    } // setInstitution()

    /**
     * Set the value of [info] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setInfo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->info !== $v) {
            $this->info = $v;
            $this->modifiedColumns[TeamTableMap::COL_INFO] = true;
        }

        return $this;
    } // setInfo()

    /**
     * Sets the value of [registr_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setRegistrDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->registr_date !== null || $dt !== null) {
            if ($this->registr_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->registr_date->format("Y-m-d H:i:s")) {
                $this->registr_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TeamTableMap::COL_REGISTR_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setRegistrDate()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TeamTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TeamTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TeamTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TeamTableMap::translateFieldName('LogoLink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->logo_link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TeamTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType)];
            $this->city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TeamTableMap::translateFieldName('Institution', TableMap::TYPE_PHPNAME, $indexType)];
            $this->institution = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TeamTableMap::translateFieldName('Info', TableMap::TYPE_PHPNAME, $indexType)];
            $this->info = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TeamTableMap::translateFieldName('RegistrDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->registr_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = TeamTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Team'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TeamTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTeamQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collstatistics = null;

            $this->collParticipantss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Team::setDeleted()
     * @see Team::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTeamQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TeamTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->statisticsScheduledForDeletion !== null) {
                if (!$this->statisticsScheduledForDeletion->isEmpty()) {
                    \StatisticQuery::create()
                        ->filterByPrimaryKeys($this->statisticsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->statisticsScheduledForDeletion = null;
                }
            }

            if ($this->collstatistics !== null) {
                foreach ($this->collstatistics as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->participantssScheduledForDeletion !== null) {
                if (!$this->participantssScheduledForDeletion->isEmpty()) {
                    \ParticipantsQuery::create()
                        ->filterByPrimaryKeys($this->participantssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->participantssScheduledForDeletion = null;
                }
            }

            if ($this->collParticipantss !== null) {
                foreach ($this->collParticipantss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TeamTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TeamTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TeamTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TeamTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(TeamTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(TeamTableMap::COL_LOGO_LINK)) {
            $modifiedColumns[':p' . $index++]  = 'logo_link';
        }
        if ($this->isColumnModified(TeamTableMap::COL_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'city';
        }
        if ($this->isColumnModified(TeamTableMap::COL_INSTITUTION)) {
            $modifiedColumns[':p' . $index++]  = 'institution';
        }
        if ($this->isColumnModified(TeamTableMap::COL_INFO)) {
            $modifiedColumns[':p' . $index++]  = 'info';
        }
        if ($this->isColumnModified(TeamTableMap::COL_REGISTR_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'registr_date';
        }

        $sql = sprintf(
            'INSERT INTO team (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'logo_link':
                        $stmt->bindValue($identifier, $this->logo_link, PDO::PARAM_STR);
                        break;
                    case 'city':
                        $stmt->bindValue($identifier, $this->city, PDO::PARAM_STR);
                        break;
                    case 'institution':
                        $stmt->bindValue($identifier, $this->institution, PDO::PARAM_STR);
                        break;
                    case 'info':
                        $stmt->bindValue($identifier, $this->info, PDO::PARAM_STR);
                        break;
                    case 'registr_date':
                        $stmt->bindValue($identifier, $this->registr_date ? $this->registr_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TeamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getEmail();
                break;
            case 3:
                return $this->getLogoLink();
                break;
            case 4:
                return $this->getCity();
                break;
            case 5:
                return $this->getInstitution();
                break;
            case 6:
                return $this->getInfo();
                break;
            case 7:
                return $this->getRegistrDate();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Team'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Team'][$this->hashCode()] = true;
        $keys = TeamTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getLogoLink(),
            $keys[4] => $this->getCity(),
            $keys[5] => $this->getInstitution(),
            $keys[6] => $this->getInfo(),
            $keys[7] => $this->getRegistrDate(),
        );
        if ($result[$keys[7]] instanceof \DateTime) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collstatistics) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'statistics';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'statistics';
                        break;
                    default:
                        $key = 'Statistics';
                }

                $result[$key] = $this->collstatistics->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collParticipantss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'participantss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'participantss';
                        break;
                    default:
                        $key = 'Participantss';
                }

                $result[$key] = $this->collParticipantss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Team
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TeamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Team
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setEmail($value);
                break;
            case 3:
                $this->setLogoLink($value);
                break;
            case 4:
                $this->setCity($value);
                break;
            case 5:
                $this->setInstitution($value);
                break;
            case 6:
                $this->setInfo($value);
                break;
            case 7:
                $this->setRegistrDate($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TeamTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLogoLink($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCity($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInstitution($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setInfo($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setRegistrDate($arr[$keys[7]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Team The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TeamTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TeamTableMap::COL_ID)) {
            $criteria->add(TeamTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TeamTableMap::COL_NAME)) {
            $criteria->add(TeamTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(TeamTableMap::COL_EMAIL)) {
            $criteria->add(TeamTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(TeamTableMap::COL_LOGO_LINK)) {
            $criteria->add(TeamTableMap::COL_LOGO_LINK, $this->logo_link);
        }
        if ($this->isColumnModified(TeamTableMap::COL_CITY)) {
            $criteria->add(TeamTableMap::COL_CITY, $this->city);
        }
        if ($this->isColumnModified(TeamTableMap::COL_INSTITUTION)) {
            $criteria->add(TeamTableMap::COL_INSTITUTION, $this->institution);
        }
        if ($this->isColumnModified(TeamTableMap::COL_INFO)) {
            $criteria->add(TeamTableMap::COL_INFO, $this->info);
        }
        if ($this->isColumnModified(TeamTableMap::COL_REGISTR_DATE)) {
            $criteria->add(TeamTableMap::COL_REGISTR_DATE, $this->registr_date);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTeamQuery::create();
        $criteria->add(TeamTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Team (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setLogoLink($this->getLogoLink());
        $copyObj->setCity($this->getCity());
        $copyObj->setInstitution($this->getInstitution());
        $copyObj->setInfo($this->getInfo());
        $copyObj->setRegistrDate($this->getRegistrDate());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getstatistics() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addstatistic($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getParticipantss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipants($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Team Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('statistic' == $relationName) {
            return $this->initstatistics();
        }
        if ('Participants' == $relationName) {
            return $this->initParticipantss();
        }
    }

    /**
     * Clears out the collstatistics collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addstatistics()
     */
    public function clearstatistics()
    {
        $this->collstatistics = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collstatistics collection loaded partially.
     */
    public function resetPartialstatistics($v = true)
    {
        $this->collstatisticsPartial = $v;
    }

    /**
     * Initializes the collstatistics collection.
     *
     * By default this just sets the collstatistics collection to an empty array (like clearcollstatistics());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initstatistics($overrideExisting = true)
    {
        if (null !== $this->collstatistics && !$overrideExisting) {
            return;
        }
        $this->collstatistics = new ObjectCollection();
        $this->collstatistics->setModel('\Statistic');
    }

    /**
     * Gets an array of ChildStatistic objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTeam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStatistic[] List of ChildStatistic objects
     * @throws PropelException
     */
    public function getstatistics(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collstatisticsPartial && !$this->isNew();
        if (null === $this->collstatistics || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collstatistics) {
                // return empty collection
                $this->initstatistics();
            } else {
                $collstatistics = ChildStatisticQuery::create(null, $criteria)
                    ->filterByTeam($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collstatisticsPartial && count($collstatistics)) {
                        $this->initstatistics(false);

                        foreach ($collstatistics as $obj) {
                            if (false == $this->collstatistics->contains($obj)) {
                                $this->collstatistics->append($obj);
                            }
                        }

                        $this->collstatisticsPartial = true;
                    }

                    return $collstatistics;
                }

                if ($partial && $this->collstatistics) {
                    foreach ($this->collstatistics as $obj) {
                        if ($obj->isNew()) {
                            $collstatistics[] = $obj;
                        }
                    }
                }

                $this->collstatistics = $collstatistics;
                $this->collstatisticsPartial = false;
            }
        }

        return $this->collstatistics;
    }

    /**
     * Sets a collection of ChildStatistic objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $statistics A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function setstatistics(Collection $statistics, ConnectionInterface $con = null)
    {
        /** @var ChildStatistic[] $statisticsToDelete */
        $statisticsToDelete = $this->getstatistics(new Criteria(), $con)->diff($statistics);


        $this->statisticsScheduledForDeletion = $statisticsToDelete;

        foreach ($statisticsToDelete as $statisticRemoved) {
            $statisticRemoved->setTeam(null);
        }

        $this->collstatistics = null;
        foreach ($statistics as $statistic) {
            $this->addstatistic($statistic);
        }

        $this->collstatistics = $statistics;
        $this->collstatisticsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Statistic objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Statistic objects.
     * @throws PropelException
     */
    public function countstatistics(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collstatisticsPartial && !$this->isNew();
        if (null === $this->collstatistics || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collstatistics) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getstatistics());
            }

            $query = ChildStatisticQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTeam($this)
                ->count($con);
        }

        return count($this->collstatistics);
    }

    /**
     * Method called to associate a ChildStatistic object to this object
     * through the ChildStatistic foreign key attribute.
     *
     * @param  ChildStatistic $l ChildStatistic
     * @return $this|\Team The current object (for fluent API support)
     */
    public function addstatistic(ChildStatistic $l)
    {
        if ($this->collstatistics === null) {
            $this->initstatistics();
            $this->collstatisticsPartial = true;
        }

        if (!$this->collstatistics->contains($l)) {
            $this->doAddstatistic($l);
        }

        return $this;
    }

    /**
     * @param ChildStatistic $statistic The ChildStatistic object to add.
     */
    protected function doAddstatistic(ChildStatistic $statistic)
    {
        $this->collstatistics[]= $statistic;
        $statistic->setTeam($this);
    }

    /**
     * @param  ChildStatistic $statistic The ChildStatistic object to remove.
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function removestatistic(ChildStatistic $statistic)
    {
        if ($this->getstatistics()->contains($statistic)) {
            $pos = $this->collstatistics->search($statistic);
            $this->collstatistics->remove($pos);
            if (null === $this->statisticsScheduledForDeletion) {
                $this->statisticsScheduledForDeletion = clone $this->collstatistics;
                $this->statisticsScheduledForDeletion->clear();
            }
            $this->statisticsScheduledForDeletion[]= clone $statistic;
            $statistic->setTeam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Team is new, it will return
     * an empty collection; or if this Team has previously
     * been saved, it will retrieve related statistics from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Team.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStatistic[] List of ChildStatistic objects
     */
    public function getstatisticsJoinTask(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStatisticQuery::create(null, $criteria);
        $query->joinWith('Task', $joinBehavior);

        return $this->getstatistics($query, $con);
    }

    /**
     * Clears out the collParticipantss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParticipantss()
     */
    public function clearParticipantss()
    {
        $this->collParticipantss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParticipantss collection loaded partially.
     */
    public function resetPartialParticipantss($v = true)
    {
        $this->collParticipantssPartial = $v;
    }

    /**
     * Initializes the collParticipantss collection.
     *
     * By default this just sets the collParticipantss collection to an empty array (like clearcollParticipantss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParticipantss($overrideExisting = true)
    {
        if (null !== $this->collParticipantss && !$overrideExisting) {
            return;
        }
        $this->collParticipantss = new ObjectCollection();
        $this->collParticipantss->setModel('\Participants');
    }

    /**
     * Gets an array of ChildParticipants objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTeam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParticipants[] List of ChildParticipants objects
     * @throws PropelException
     */
    public function getParticipantss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantssPartial && !$this->isNew();
        if (null === $this->collParticipantss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParticipantss) {
                // return empty collection
                $this->initParticipantss();
            } else {
                $collParticipantss = ChildParticipantsQuery::create(null, $criteria)
                    ->filterByTeam($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParticipantssPartial && count($collParticipantss)) {
                        $this->initParticipantss(false);

                        foreach ($collParticipantss as $obj) {
                            if (false == $this->collParticipantss->contains($obj)) {
                                $this->collParticipantss->append($obj);
                            }
                        }

                        $this->collParticipantssPartial = true;
                    }

                    return $collParticipantss;
                }

                if ($partial && $this->collParticipantss) {
                    foreach ($this->collParticipantss as $obj) {
                        if ($obj->isNew()) {
                            $collParticipantss[] = $obj;
                        }
                    }
                }

                $this->collParticipantss = $collParticipantss;
                $this->collParticipantssPartial = false;
            }
        }

        return $this->collParticipantss;
    }

    /**
     * Sets a collection of ChildParticipants objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $participantss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function setParticipantss(Collection $participantss, ConnectionInterface $con = null)
    {
        /** @var ChildParticipants[] $participantssToDelete */
        $participantssToDelete = $this->getParticipantss(new Criteria(), $con)->diff($participantss);


        $this->participantssScheduledForDeletion = $participantssToDelete;

        foreach ($participantssToDelete as $participantsRemoved) {
            $participantsRemoved->setTeam(null);
        }

        $this->collParticipantss = null;
        foreach ($participantss as $participants) {
            $this->addParticipants($participants);
        }

        $this->collParticipantss = $participantss;
        $this->collParticipantssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Participants objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Participants objects.
     * @throws PropelException
     */
    public function countParticipantss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantssPartial && !$this->isNew();
        if (null === $this->collParticipantss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipantss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParticipantss());
            }

            $query = ChildParticipantsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTeam($this)
                ->count($con);
        }

        return count($this->collParticipantss);
    }

    /**
     * Method called to associate a ChildParticipants object to this object
     * through the ChildParticipants foreign key attribute.
     *
     * @param  ChildParticipants $l ChildParticipants
     * @return $this|\Team The current object (for fluent API support)
     */
    public function addParticipants(ChildParticipants $l)
    {
        if ($this->collParticipantss === null) {
            $this->initParticipantss();
            $this->collParticipantssPartial = true;
        }

        if (!$this->collParticipantss->contains($l)) {
            $this->doAddParticipants($l);
        }

        return $this;
    }

    /**
     * @param ChildParticipants $participants The ChildParticipants object to add.
     */
    protected function doAddParticipants(ChildParticipants $participants)
    {
        $this->collParticipantss[]= $participants;
        $participants->setTeam($this);
    }

    /**
     * @param  ChildParticipants $participants The ChildParticipants object to remove.
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function removeParticipants(ChildParticipants $participants)
    {
        if ($this->getParticipantss()->contains($participants)) {
            $pos = $this->collParticipantss->search($participants);
            $this->collParticipantss->remove($pos);
            if (null === $this->participantssScheduledForDeletion) {
                $this->participantssScheduledForDeletion = clone $this->collParticipantss;
                $this->participantssScheduledForDeletion->clear();
            }
            $this->participantssScheduledForDeletion[]= clone $participants;
            $participants->setTeam(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->email = null;
        $this->logo_link = null;
        $this->city = null;
        $this->institution = null;
        $this->info = null;
        $this->registr_date = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collstatistics) {
                foreach ($this->collstatistics as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collParticipantss) {
                foreach ($this->collParticipantss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collstatistics = null;
        $this->collParticipantss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TeamTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
