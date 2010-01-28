//
//  CNTopicList.m
//  Constellation
//
//  Created by Adam Venturella on 1/26/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "CNTopicList.h"


@implementation CNTopicList
- (void) prepareCommand
{
	self.method   = kGalaxyMethodGet;
	self.endpoint = @"topics";
}
@end
