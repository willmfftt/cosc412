<?php

namespace Base;

use \Supervisor as ChildSupervisor;
use \SupervisorQuery as ChildSupervisorQuery;
use \Exception;
use \PDO;
use Map\SupervisorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'supervisor' table.
 *
 *
 *
 * @method     ChildSupervisorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSupervisorQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method     ChildSupervisorQuery orderByManagerid($order = Criteria::ASC) Order by the managerId column
 *
 * @method     ChildSupervisorQuery groupById() Group by the id column
 * @method     ChildSupervisorQuery groupByUserid() Group by the userId column
 * @method     ChildSupervisorQuery groupByManagerid() Group by the managerId column
 *
 * @method     ChildSupervisorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSupervisorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSupervisorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSupervisorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSupervisorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSupervisorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSupervisorQuery leftJoinManager($relationAlias = null) Adds a LEFT JOIN clause to the query using the Manager relation
 * @method     ChildSupervisorQuery rightJoinManager($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Manager relation
 * @method     ChildSupervisorQuery innerJoinManager($relationAlias = null) Adds a INNER JOIN clause to the query using the Manager relation
 *
 * @method     ChildSupervisorQuery joinWithManager($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Manager relation
 *
 * @method     ChildSupervisorQuery leftJoinWithManager() Adds a LEFT JOIN clause and with to the query using the Manager relation
 * @method     ChildSupervisorQuery rightJoinWithManager() Adds a RIGHT JOIN clause and with to the query using the Manager relation
 * @method     ChildSupervisorQuery innerJoinWithManager() Adds a INNER JOIN clause and with to the query using the Manager relation
 *
 * @method     \ManagerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSupervisor findOne(ConnectionInterface $con = null) Return the first ChildSupervisor matching the query
 * @method     ChildSupervisor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSupervisor matching the query, or a new ChildSupervisor object populated from the query conditions when no match is found
 *
 * @method     ChildSupervisor findOneById(int $id) Return the first ChildSupervisor filtered by the id column
 * @method     ChildSupervisor findOneByUserid(int $userId) Return the first ChildSupervisor filtered by the userId column
 * @method     ChildSupervisor findOneByManagerid(int $managerId) Return the first ChildSupervisor filtered by the managerId column *

 * @method     ChildSupervisor requirePk($key, ConnectionInterface $con = null) Return the ChildSupervisor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSupervisor requireOne(ConnectionInterface $con = null) Return the first ChildSupervisor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSupervisor requireOneById(int $id) Return the first ChildSupervisor filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSupervisor requireOneByUserid(int $userId) Return the first ChildSupervisor filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSupervisor requireOneByManagerid(int $managerId) Return the first ChildSupervisor filtered by the managerId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSupervisor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSupervisor objects based on current ModelCriteria
 * @method     ChildSupervisor[]|ObjectCollection findById(int $id) Return ChildSupervisor objects filtered by the id column
 * @method     ChildSupervisor[]|ObjectCollection findByUserid(int $userId) Return ChildSupervisor objects filtered by the userId column
 * @method     ChildSupervisor[]|ObjectCollection findByManagerid(int $managerId) Return ChildSupervisor objects filtered by the managerId column
 * @method     ChildSupervisor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SupervisorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SupervisorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Supervisor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSupervisorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSupervisorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSupervisorQuery) {
            return $criteria;
        }
        $query = new ChildSupervisorQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSupervisor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SupervisorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SupervisorTableMap::DATABASE_NAME);
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
     * @return ChildSupervisor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, userId, managerId FROM supervisor WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSupervisor $obj */
            $obj = new ChildSupervisor();
            $obj->hydrate($row);
            SupervisorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSupervisor|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SupervisorTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SupervisorTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SupervisorTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SupervisorTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SupervisorTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the userId column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userId = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userId IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userId > 12
     * </code>
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(SupervisorTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(SupervisorTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SupervisorTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the managerId column
     *
     * Example usage:
     * <code>
     * $query->filterByManagerid(1234); // WHERE managerId = 1234
     * $query->filterByManagerid(array(12, 34)); // WHERE managerId IN (12, 34)
     * $query->filterByManagerid(array('min' => 12)); // WHERE managerId > 12
     * </code>
     *
     * @see       filterByManager()
     *
     * @param     mixed $managerid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function filterByManagerid($managerid = null, $comparison = null)
    {
        if (is_array($managerid)) {
            $useMinMax = false;
            if (isset($managerid['min'])) {
                $this->addUsingAlias(SupervisorTableMap::COL_MANAGERID, $managerid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($managerid['max'])) {
                $this->addUsingAlias(SupervisorTableMap::COL_MANAGERID, $managerid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SupervisorTableMap::COL_MANAGERID, $managerid, $comparison);
    }

    /**
     * Filter the query by a related \Manager object
     *
     * @param \Manager|ObjectCollection $manager The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSupervisorQuery The current query, for fluid interface
     */
    public function filterByManager($manager, $comparison = null)
    {
        if ($manager instanceof \Manager) {
            return $this
                ->addUsingAlias(SupervisorTableMap::COL_MANAGERID, $manager->getId(), $comparison);
        } elseif ($manager instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SupervisorTableMap::COL_MANAGERID, $manager->toKeyValue('Id', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByManager() only accepts arguments of type \Manager or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Manager relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function joinManager($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Manager');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Manager');
        }

        return $this;
    }

    /**
     * Use the Manager relation Manager object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ManagerQuery A secondary query class using the current class as primary query
     */
    public function useManagerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinManager($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Manager', '\ManagerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSupervisor $supervisor Object to remove from the list of results
     *
     * @return $this|ChildSupervisorQuery The current query, for fluid interface
     */
    public function prune($supervisor = null)
    {
        if ($supervisor) {
            $this->addUsingAlias(SupervisorTableMap::COL_ID, $supervisor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the supervisor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SupervisorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SupervisorTableMap::clearInstancePool();
            SupervisorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SupervisorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SupervisorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SupervisorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SupervisorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SupervisorQuery
