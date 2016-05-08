<?php

namespace Base;

use \Attempt as ChildAttempt;
use \AttemptQuery as ChildAttemptQuery;
use \Statistic as ChildStatistic;
use \StatisticQuery as ChildStatisticQuery;
use \Task as ChildTask;
use \TaskQuery as ChildTaskQuery;
use \Team as ChildTeam;
use \TeamQuery as ChildTeamQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\StatisticTableMap;
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
 * Base class that represents a row from the 'statistic' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Statistic implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\StatisticTableMap';


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
     * The value for the team_id field.
     *
     * @var        int
     */
    protected $team_id;

    /**
     * The value for the task_id field.
     *
     * @var        int
     */
    protected $task_id;

    /**
     * The value for the flag_done field.
     *
     * @var        boolean
     */
    protected $flag_done;

    /**
     * The value for the time_done field.
     *
     * @var        \DateTime
     */
    protected $time_done;

    /**
     * @var        ChildTeam
     */
    protected $aTeam;

    /**
     * @var        ChildTask
     */
    protected $aTask;

    /**
     * @var        ObjectCollection|ChildAttempt[] Collection to store aggregation of ChildAttempt objects.
     */
    protected $collAttempts;
    protected $collAttemptsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAttempt[]
     */
    protected $attemptsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Statistic object.
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
     * Compares this with another <code>Statistic</code> instance.  If
     * <code>obj</code> is an instance of <code>Statistic</code>, delegates to
     * <code>equals(Statistic)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Statistic The current object, for fluid interface
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
     * Get the [team_id] column value.
     *
     * @return int
     */
    public function getTeamId()
    {
        return $this->team_id;
    }

    /**
     * Get the [task_id] column value.
     *
     * @return int
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * Get the [flag_done] column value.
     *
     * @return boolean
     */
    public function getFlagDone()
    {
        return $this->flag_done;
    }

    /**
     * Get the [flag_done] column value.
     *
     * @return boolean
     */
    public function isFlagDone()
    {
        return $this->getFlagDone();
    }

    /**
     * Get the [optionally formatted] temporal [time_done] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimeDone($format = NULL)
    {
        if ($format === null) {
            return $this->time_done;
        } else {
            return $this->time_done instanceof \DateTime ? $this->time_done->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Statistic The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[StatisticTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [team_id] column.
     *
     * @param int $v new value
     * @return $this|\Statistic The current object (for fluent API support)
     */
    public function setTeamId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->team_id !== $v) {
            $this->team_id = $v;
            $this->modifiedColumns[StatisticTableMap::COL_TEAM_ID] = true;
        }

        if ($this->aTeam !== null && $this->aTeam->getId() !== $v) {
            $this->aTeam = null;
        }

        return $this;
    } // setTeamId()

    /**
     * Set the value of [task_id] column.
     *
     * @param int $v new value
     * @return $this|\Statistic The current object (for fluent API support)
     */
    public function setTaskId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->task_id !== $v) {
            $this->task_id = $v;
            $this->modifiedColumns[StatisticTableMap::COL_TASK_ID] = true;
        }

        if ($this->aTask !== null && $this->aTask->getId() !== $v) {
            $this->aTask = null;
        }

        return $this;
    } // setTaskId()

    /**
     * Sets the value of the [flag_done] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Statistic The current object (for fluent API support)
     */
    public function setFlagDone($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->flag_done !== $v) {
            $this->flag_done = $v;
            $this->modifiedColumns[StatisticTableMap::COL_FLAG_DONE] = true;
        }

        return $this;
    } // setFlagDone()

    /**
     * Sets the value of [time_done] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Statistic The current object (for fluent API support)
     */
    public function setTimeDone($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->time_done !== null || $dt !== null) {
            if ($this->time_done === null || $dt === null || $dt->format("H:i:s") !== $this->time_done->format("H:i:s")) {
                $this->time_done = $dt === null ? null : clone $dt;
                $this->modifiedColumns[StatisticTableMap::COL_TIME_DONE] = true;
            }
        } // if either are not null

        return $this;
    } // setTimeDone()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StatisticTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StatisticTableMap::translateFieldName('TeamId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->team_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StatisticTableMap::translateFieldName('TaskId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->task_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StatisticTableMap::translateFieldName('FlagDone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->flag_done = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StatisticTableMap::translateFieldName('TimeDone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->time_done = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = StatisticTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Statistic'), 0, $e);
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
        if ($this->aTeam !== null && $this->team_id !== $this->aTeam->getId()) {
            $this->aTeam = null;
        }
        if ($this->aTask !== null && $this->task_id !== $this->aTask->getId()) {
            $this->aTask = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(StatisticTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStatisticQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTeam = null;
            $this->aTask = null;
            $this->collAttempts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Statistic::setDeleted()
     * @see Statistic::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StatisticTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildStatisticQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(StatisticTableMap::DATABASE_NAME);
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
                StatisticTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTeam !== null) {
                if ($this->aTeam->isModified() || $this->aTeam->isNew()) {
                    $affectedRows += $this->aTeam->save($con);
                }
                $this->setTeam($this->aTeam);
            }

            if ($this->aTask !== null) {
                if ($this->aTask->isModified() || $this->aTask->isNew()) {
                    $affectedRows += $this->aTask->save($con);
                }
                $this->setTask($this->aTask);
            }

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

            if ($this->attemptsScheduledForDeletion !== null) {
                if (!$this->attemptsScheduledForDeletion->isEmpty()) {
                    \AttemptQuery::create()
                        ->filterByPrimaryKeys($this->attemptsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->attemptsScheduledForDeletion = null;
                }
            }

            if ($this->collAttempts !== null) {
                foreach ($this->collAttempts as $referrerFK) {
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

        $this->modifiedColumns[StatisticTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StatisticTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StatisticTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(StatisticTableMap::COL_TEAM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'team_id';
        }
        if ($this->isColumnModified(StatisticTableMap::COL_TASK_ID)) {
            $modifiedColumns[':p' . $index++]  = 'task_id';
        }
        if ($this->isColumnModified(StatisticTableMap::COL_FLAG_DONE)) {
            $modifiedColumns[':p' . $index++]  = 'flag_done';
        }
        if ($this->isColumnModified(StatisticTableMap::COL_TIME_DONE)) {
            $modifiedColumns[':p' . $index++]  = 'time_done';
        }

        $sql = sprintf(
            'INSERT INTO statistic (%s) VALUES (%s)',
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
                    case 'team_id':
                        $stmt->bindValue($identifier, $this->team_id, PDO::PARAM_INT);
                        break;
                    case 'task_id':
                        $stmt->bindValue($identifier, $this->task_id, PDO::PARAM_INT);
                        break;
                    case 'flag_done':
                        $stmt->bindValue($identifier, (int) $this->flag_done, PDO::PARAM_INT);
                        break;
                    case 'time_done':
                        $stmt->bindValue($identifier, $this->time_done ? $this->time_done->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = StatisticTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTeamId();
                break;
            case 2:
                return $this->getTaskId();
                break;
            case 3:
                return $this->getFlagDone();
                break;
            case 4:
                return $this->getTimeDone();
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

        if (isset($alreadyDumpedObjects['Statistic'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Statistic'][$this->hashCode()] = true;
        $keys = StatisticTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTeamId(),
            $keys[2] => $this->getTaskId(),
            $keys[3] => $this->getFlagDone(),
            $keys[4] => $this->getTimeDone(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTeam) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'team';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'team';
                        break;
                    default:
                        $key = 'Team';
                }

                $result[$key] = $this->aTeam->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTask) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'task';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'task';
                        break;
                    default:
                        $key = 'Task';
                }

                $result[$key] = $this->aTask->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAttempts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'attempts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'attempts';
                        break;
                    default:
                        $key = 'Attempts';
                }

                $result[$key] = $this->collAttempts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Statistic
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StatisticTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Statistic
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTeamId($value);
                break;
            case 2:
                $this->setTaskId($value);
                break;
            case 3:
                $this->setFlagDone($value);
                break;
            case 4:
                $this->setTimeDone($value);
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
        $keys = StatisticTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTeamId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTaskId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFlagDone($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTimeDone($arr[$keys[4]]);
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
     * @return $this|\Statistic The current object, for fluid interface
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
        $criteria = new Criteria(StatisticTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StatisticTableMap::COL_ID)) {
            $criteria->add(StatisticTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(StatisticTableMap::COL_TEAM_ID)) {
            $criteria->add(StatisticTableMap::COL_TEAM_ID, $this->team_id);
        }
        if ($this->isColumnModified(StatisticTableMap::COL_TASK_ID)) {
            $criteria->add(StatisticTableMap::COL_TASK_ID, $this->task_id);
        }
        if ($this->isColumnModified(StatisticTableMap::COL_FLAG_DONE)) {
            $criteria->add(StatisticTableMap::COL_FLAG_DONE, $this->flag_done);
        }
        if ($this->isColumnModified(StatisticTableMap::COL_TIME_DONE)) {
            $criteria->add(StatisticTableMap::COL_TIME_DONE, $this->time_done);
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
        $criteria = ChildStatisticQuery::create();
        $criteria->add(StatisticTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Statistic (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTeamId($this->getTeamId());
        $copyObj->setTaskId($this->getTaskId());
        $copyObj->setFlagDone($this->getFlagDone());
        $copyObj->setTimeDone($this->getTimeDone());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAttempts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAttempt($relObj->copy($deepCopy));
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
     * @return \Statistic Clone of current object.
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
     * Declares an association between this object and a ChildTeam object.
     *
     * @param  ChildTeam $v
     * @return $this|\Statistic The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTeam(ChildTeam $v = null)
    {
        if ($v === null) {
            $this->setTeamId(NULL);
        } else {
            $this->setTeamId($v->getId());
        }

        $this->aTeam = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTeam object, it will not be re-added.
        if ($v !== null) {
            $v->addstatistic($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTeam object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTeam The associated ChildTeam object.
     * @throws PropelException
     */
    public function getTeam(ConnectionInterface $con = null)
    {
        if ($this->aTeam === null && ($this->team_id !== null)) {
            $this->aTeam = ChildTeamQuery::create()->findPk($this->team_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTeam->addstatistics($this);
             */
        }

        return $this->aTeam;
    }

    /**
     * Declares an association between this object and a ChildTask object.
     *
     * @param  ChildTask $v
     * @return $this|\Statistic The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTask(ChildTask $v = null)
    {
        if ($v === null) {
            $this->setTaskId(NULL);
        } else {
            $this->setTaskId($v->getId());
        }

        $this->aTask = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTask object, it will not be re-added.
        if ($v !== null) {
            $v->addstatistic($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTask object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTask The associated ChildTask object.
     * @throws PropelException
     */
    public function getTask(ConnectionInterface $con = null)
    {
        if ($this->aTask === null && ($this->task_id !== null)) {
            $this->aTask = ChildTaskQuery::create()->findPk($this->task_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTask->addstatistics($this);
             */
        }

        return $this->aTask;
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
        if ('Attempt' == $relationName) {
            return $this->initAttempts();
        }
    }

    /**
     * Clears out the collAttempts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAttempts()
     */
    public function clearAttempts()
    {
        $this->collAttempts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAttempts collection loaded partially.
     */
    public function resetPartialAttempts($v = true)
    {
        $this->collAttemptsPartial = $v;
    }

    /**
     * Initializes the collAttempts collection.
     *
     * By default this just sets the collAttempts collection to an empty array (like clearcollAttempts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAttempts($overrideExisting = true)
    {
        if (null !== $this->collAttempts && !$overrideExisting) {
            return;
        }
        $this->collAttempts = new ObjectCollection();
        $this->collAttempts->setModel('\Attempt');
    }

    /**
     * Gets an array of ChildAttempt objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAttempt[] List of ChildAttempt objects
     * @throws PropelException
     */
    public function getAttempts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAttemptsPartial && !$this->isNew();
        if (null === $this->collAttempts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAttempts) {
                // return empty collection
                $this->initAttempts();
            } else {
                $collAttempts = ChildAttemptQuery::create(null, $criteria)
                    ->filterByStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAttemptsPartial && count($collAttempts)) {
                        $this->initAttempts(false);

                        foreach ($collAttempts as $obj) {
                            if (false == $this->collAttempts->contains($obj)) {
                                $this->collAttempts->append($obj);
                            }
                        }

                        $this->collAttemptsPartial = true;
                    }

                    return $collAttempts;
                }

                if ($partial && $this->collAttempts) {
                    foreach ($this->collAttempts as $obj) {
                        if ($obj->isNew()) {
                            $collAttempts[] = $obj;
                        }
                    }
                }

                $this->collAttempts = $collAttempts;
                $this->collAttemptsPartial = false;
            }
        }

        return $this->collAttempts;
    }

    /**
     * Sets a collection of ChildAttempt objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $attempts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildStatistic The current object (for fluent API support)
     */
    public function setAttempts(Collection $attempts, ConnectionInterface $con = null)
    {
        /** @var ChildAttempt[] $attemptsToDelete */
        $attemptsToDelete = $this->getAttempts(new Criteria(), $con)->diff($attempts);


        $this->attemptsScheduledForDeletion = $attemptsToDelete;

        foreach ($attemptsToDelete as $attemptRemoved) {
            $attemptRemoved->setStatistic(null);
        }

        $this->collAttempts = null;
        foreach ($attempts as $attempt) {
            $this->addAttempt($attempt);
        }

        $this->collAttempts = $attempts;
        $this->collAttemptsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Attempt objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Attempt objects.
     * @throws PropelException
     */
    public function countAttempts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAttemptsPartial && !$this->isNew();
        if (null === $this->collAttempts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAttempts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAttempts());
            }

            $query = ChildAttemptQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStatistic($this)
                ->count($con);
        }

        return count($this->collAttempts);
    }

    /**
     * Method called to associate a ChildAttempt object to this object
     * through the ChildAttempt foreign key attribute.
     *
     * @param  ChildAttempt $l ChildAttempt
     * @return $this|\Statistic The current object (for fluent API support)
     */
    public function addAttempt(ChildAttempt $l)
    {
        if ($this->collAttempts === null) {
            $this->initAttempts();
            $this->collAttemptsPartial = true;
        }

        if (!$this->collAttempts->contains($l)) {
            $this->doAddAttempt($l);
        }

        return $this;
    }

    /**
     * @param ChildAttempt $attempt The ChildAttempt object to add.
     */
    protected function doAddAttempt(ChildAttempt $attempt)
    {
        $this->collAttempts[]= $attempt;
        $attempt->setStatistic($this);
    }

    /**
     * @param  ChildAttempt $attempt The ChildAttempt object to remove.
     * @return $this|ChildStatistic The current object (for fluent API support)
     */
    public function removeAttempt(ChildAttempt $attempt)
    {
        if ($this->getAttempts()->contains($attempt)) {
            $pos = $this->collAttempts->search($attempt);
            $this->collAttempts->remove($pos);
            if (null === $this->attemptsScheduledForDeletion) {
                $this->attemptsScheduledForDeletion = clone $this->collAttempts;
                $this->attemptsScheduledForDeletion->clear();
            }
            $this->attemptsScheduledForDeletion[]= clone $attempt;
            $attempt->setStatistic(null);
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
        if (null !== $this->aTeam) {
            $this->aTeam->removestatistic($this);
        }
        if (null !== $this->aTask) {
            $this->aTask->removestatistic($this);
        }
        $this->id = null;
        $this->team_id = null;
        $this->task_id = null;
        $this->flag_done = null;
        $this->time_done = null;
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
            if ($this->collAttempts) {
                foreach ($this->collAttempts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAttempts = null;
        $this->aTeam = null;
        $this->aTask = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StatisticTableMap::DEFAULT_STRING_FORMAT);
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
