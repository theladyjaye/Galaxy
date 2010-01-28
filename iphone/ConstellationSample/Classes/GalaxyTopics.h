//
//  GalaxyTopics.h
//  ConstellationSample
//
//  Created by Adam Venturella on 1/27/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ConstellationDelegate.h"

@class Constellation;
@interface GalaxyTopics : UITableViewController<ConstellationDelegate> {
	NSString * forum;
	Constellation * constellation;
	NSArray * dataProvider;
}
- (id)initWithForum:(NSString *)target constellation:(Constellation *)cn;

@end
