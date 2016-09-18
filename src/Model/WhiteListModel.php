<?php
/**
 * OperaSampleSite
 * WhiteListModel.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   12-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Model;


use Opera\Component\Database\AbstractModel;
use PDO;

class WhiteListModel extends AbstractModel
{
    public function isWhiteListed(string $ip) : bool
    {
        $db = $this->getReader();
        $statement = $db->prepare('SELECT COUNT(*) as count FROM white_list WHERE ip = :ip');
        $statement->bindValue('ip', $ip, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn() == 1;
    }

}
