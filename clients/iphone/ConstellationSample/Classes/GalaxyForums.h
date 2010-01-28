//
//  GalaxyForums.h
//  ConstellationSample
//
//  Created by Adam Venturella on 1/27/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ConstellationDelegate.h"
@class Constellation;
@interface GalaxyForums : UITableViewController <ConstellationDelegate> {
	Constellation * constellation;
	NSArray * dataProvider;
}

@end
