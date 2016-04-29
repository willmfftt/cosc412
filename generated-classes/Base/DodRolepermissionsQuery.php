<?php

namespace Base;

use \DodRolepermissions as ChildDodRolepermissions;
use \DodRolepermissionsQuery as ChildDodRolepermissionsQuery;
use \Exception;
use \PDO;
use Map\DodRolepermissionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dod_rolepermissions' table.
 *
 *
 *
 * @method     ChildDodRolepermissionsQuery orderByRoleid($order = Criteria::ASC) Order by the RoleID column
 * @method     ChildDodRolepermissionsQuery orderByPermissionid($order = Criteria::ASC) Order by the PermissionID column
 * @method     ChildDodRolepermissionsQuery orderByAssignmentdate($order = Criteria::ASC) Order by the AssignmentDate column
 *
 * @method     ChildDodRolepermissionsQuery groupByRoleid() Group by the RoleID column
 * @method     ChildDodRolepermissionsQuery groupByPermissionid() Group by the PermissionID column
 * @method     ChildDodRolepermissionsQuery groupByAssignmentdate() Group by the AssignmentDate column
 *
 * @method     ChildDodRolepermissionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDodRolepermissionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDodRolepermissionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDodRolepermissionsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDodRolepermissionsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDodRolepermissionsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDodRolepermissions findOne(ConnectionInterface $con = null) Return the first ChildDodRolepermissions matching the query
 * @method     ChildDodRolepermissions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDodRolepermissions matching the query, or a new ChildDodRolepermissions object populated from the query conditions when no match is found
 *
 * @method     ChildDodRolepermissions findOneByRoleid(int $RoleID) Return the first ChildDodRolepermissions filtered by the RoleID column
 * @method     ChildDodRolepermissions findOneByPermissionid(int $PermissionID) Return the first ChildDodRolepermissions filtered by the PermissionID column
 * @method     ChildDodRolepermissions findOneByAssignmentdate(int $AssignmentDate) Return the first ChildDodRolepermissions filtered by the AssignmentDate column *

 * @method     ChildDodRolepermissions requirePk($key, ConnectionInterface $con = null) Return the ChildDodRolepermissions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodRolepermissions requireOne(ConnectionInterface $con = null) Return the first ChildDodRolepermissions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDodRolepermissions requireOneByRoleid(int $RoleID) Return the first ChildDodRolepermissions filtered by the RoleID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodRolepermissions requireOneByPermissionid(int $PermissionID) Return the first ChildDodRolepermissions filtered by the PermissionID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDodRolepermissions requireOneByAssignmentdate(int $AssignmentDate) Return the first ChildDodRolepermissions filtered by the AssignmentDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDodRolepermissions[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDodRolepermissions objects based on current ModelCriteria
 * @method     ChildDodRolepermissions[]|ObjectCollection findByRoleid(int $RoleID) Return ChildDodRolepermissions objects filtered by the RoleID column
 * @method     ChildDodRolepermissions[]|ObjectCollection findByPermissionid(int $PermissionID) Return ChildDodRolepermissions objects filtered by the PermissionID column
 * @method     ChildDodRolepermissions[]|ObjectCollection findByAssignmentdate(int $AssignmentDate) Return ChildDodRolepermissions objects filtered by the AssignmentDate column
 * @method     ChildDodRolepermissions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DodRolepermissionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DodRolepermissionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DodRolepermissions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDodRolepermissionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDodRolepermissionsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDodRolepermissionsQuery) {
            return $criteria;
        }
        $query = new ChildDodRolepermissionsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$RoleID, $PermissionID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDodRolepermissions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DodRolepermissionsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DodRolepermissionsTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDodRolepermissions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT RoleID, PermissionID, AssignmentDate FROM dod_rolepermissions WHERE RoleID = :p0 AND PermissionID = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDodRolepermissions $obj */
            $obj = new ChildDodRolepermissions();
            $obj->hydrate($row);
            DodRolepermissionsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDodRolepermissions|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDodRolepermissionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(DodRolepermissionsTableMap::COL_ROLEID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(DodRolepermissionsTableMap::COL_PERMISSIONID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDodRolepermissionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(DodRolepermissionsTableMap::COL_ROLEID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(DodRolepermissionsTableMap::COL_PERMISSIONID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the RoleID column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleid(1234); // WHERE RoleID = 1234
     * $query->filterByRoleid(array(12, 34)); // WHERE RoleID IN (12, 34)
     * $query->filterByRoleid(array('min' => 12)); // WHERE RoleID > 12
     * </code>
     *
     * @param     mixed $roleid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodRolepermissionsQuery The current query, for fluid interface
     */
    public function filterByRoleid($roleid = null, $comparison = null)
    {
        if (is_array($roleid)) {
            $useMinMax = false;
            if (isset($roleid['min'])) {
                $this->addUsingAlias(DodRolepermissionsTableMap::COL_ROLEID, $roleid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleid['max'])) {
                $this->addUsingAlias(DodRolepermissionsTableMap::COL_ROLEID, $roleid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DodRolepermissionsTableMap::COL_ROLEID, $roleid, $comparison);
    }

    /**
     * Filter the query on the PermissionID column
     *
     * Example usage:
     * <code>
     * $query->filterByPermissionid(1234); // WHERE PermissionID = 1234
     * $query->filterByPermissionid(array(12, 34)); // WHERE PermissionID IN (12, 34)
     * $query->filterByPermissionid(array('min' => 12)); // WHERE PermissionID > 12
     * </code>
     *
     * @param     mixed $permissionid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodRolepermissionsQuery The current query, for fluid interface
     */
    public function filterByPermissionid($permissionid = null, $comparison = null)
    {
        if (is_array($permissionid)) {
            $useMinMax = false;
            if (isset($permissionid['min'])) {
                $this->addUsingAlias(DodRolepermissionsTableMap::COL_PERMISSIONID, $permissionid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($permissionid['max'])) {
                $this->addUsingAlias(DodRolepermissionsTableMap::COL_PERMISSIONID, $permissionid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DodRolepermissionsTableMap::COL_PERMISSIONID, $permissionid, $comparison);
    }

    /**
     * Filter the query on the AssignmentDate column
     *
     * Example usage:
     * <code>
     * $query->filterByAssignmentdate(1234); // WHERE AssignmentDate = 1234
     * $query->filterByAssignmentdate(array(12, 34)); // WHERE AssignmentDate IN (12, 34)
     * $query->filterByAssignmentdate(array('min' => 12)); // WHERE AssignmentDate > 12
     * </code>
     *
     * @param     mixed $assignmentdate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDodRolepermissionsQuery The current query, for fluid interface
     */
    public function filterByAssignmentdate($assignmentdate = null, $comparison = null)
    {
        if (is_array($assignmentdate)) {
            $useMinMax = false;
            if (isset($assignmentdate['min'])) {
                $this->addUsingAlias(DodRolepermissionsTableMap::COL_ASSIGNMENTDATE, $assignmentdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assignmentdate['max'])) {
                $this->addUsingAlias(DodRolepermissionsTableMap::COL_ASSIGNMENTDATE, $assignmentdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DodRolepermissionsTableMap::COL_ASSIGNMENTDATE, $assignmentdate, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDodRolepermissions $dodRolepermissions Object to remove from the list of results
     *
     * @return $this|ChildDodRolepermissionsQuery The current query, for fluid interface
     */
    public function prune($dodRolepermissions = null)
    {
        if ($dodRolepermissions) {
            $this->addCond('pruneCond0', $this->getAliasedColName(DodRolepermissionsTableMap::COL_ROLEID), $dodRolepermissions->getRoleid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(DodRolepermissionsTableMap::COL_PERMISSIONID), $dodRolepermissions->getPermissionid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dod_rolepermissions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DodRolepermissionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DodRolepermissionsTableMap::clearInstancePool();
            DodRolepermissionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DodRolepermissionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DodRolepermissionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DodRolepermissionsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DodRolepermissionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DodRolepermissionsQuery
