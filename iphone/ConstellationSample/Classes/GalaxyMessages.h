//
//  GalaxyMessages.h
//  ConstellationSample
//
//  Created by Adam Venturella on 1/27/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ConstellationDelegate.h"

@class Constellation;
@interface GalaxyMessages : UITableViewController<ConstellationDelegate> {
	NSString * topic;
	Constellation * constellation;
	NSArray * dataProvider;
}
- (id)initWithTopic:(NSString *)target constellation:(Constellation *)cn;
@end
