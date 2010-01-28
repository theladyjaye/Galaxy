//
//  CNMessages.m
//  Constellation
//
//  Created by Adam Venturella on 1/27/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "CNMessages.h"


@implementation CNMessages
- (void) prepareCommand
{
	self.method   = kGalaxyMethodGet;
	self.endpoint = @"messages";
}
@end
