<?php
/**
 *    Galaxy - Foundry
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package foundry
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/

// Please note that the API end of things also holds a copy of these, so if you update here, please update there.

class RenegadeConstants
{
	const kDatabaseCouchDB       = 1;
	const kDatabaseTokyoCabinet  = 2;
	const kDatabaseRedis         = 3;
	const kDatabaseMongoDB       = 4;
	
	const kDatabaseUsers         = 0;
	const kDatabaseSessions      = 1;
	const kDatabaseVerification  = 2;
	const kDatabaseCertificates  = 3;
	const kDatabaseApplications  = 'applications';
	const kDatabaseChannels      = 'channels';
	const kDatabaseSubscriptions = 'subscriptions';
	const kDatabaseDefault       = 'galaxy';
	
	// trying to keep the prefixes all in one place
	// might make more sense to store them in their individual objects though.
	// for ease of configuration though they are here for now.
	const kTypeVerification     = 'verify';
	const kTypeSession          = 'session';
	const kTypeUser             = 'user';
	const kTypeChannel          = 'channel';
	const kTypeCertificate      = 'cert';
	const kTypeApplication      = 'application';
	const kTypeForum            = 'forum';
	const kTypeSubscription     = 'subscription';
	
	const kSessionKey           = 'Renegade';
	const kChannelPrefix        = 'renegade/channels';
	
	const kPermissionRead       = 1;
	const kPermissionWrite      = 2;
	const kPermissionDelete     = 4;
	
	const kSchemeGalaxy         = 'glxy://';
}
?>